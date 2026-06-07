<?php
if (($_GET['q'] ?? '') === 'run_kmeans' && isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $result = $conn->query("SELECT geojson_path FROM shp_upload WHERE id = {$id} LIMIT 1");
    $row = $result ? $result->fetch_assoc() : null;

    if (!$row || empty($row['geojson_path'])) {
        echo "<script>alert('Path GeoJSON tidak ditemukan.'); window.history.back();</script>";
        exit;
    }

    // path RELATIVE dari database
    $geojson_rel = str_replace('\\', '/', $row['geojson_path']);

    // path ABSOLUTE untuk proses file di server
    $geojson_file = realpath(__DIR__ . "/../../../") . "/" . $geojson_rel;
    $geojson_file = str_replace('\\', '/', $geojson_file);

    if (!file_exists($geojson_file)) {
        echo "<script>alert('File GeoJSON tidak ditemukan.'); window.history.back();</script>";
        exit;
    }

    $json = file_get_contents($geojson_file);
    $data = json_decode($json, true);

    if (!$data || !isset($data['features']) || !is_array($data['features'])) {
        echo "<script>alert('Format GeoJSON tidak valid.'); window.history.back();</script>";
        exit;
    }

    $features = $data['features'];
    $values = [];
    $trueSet = [];

    foreach ($features as $i => $feat) {
        $raw = $feat['properties']['RPBULAT'] ?? null;
        $clean = $raw !== null ? floatval(preg_replace('/[^0-9]/', '', $raw)) : 0;

        if ($clean <= 0) {
            echo "<script>alert('RPBULAT tidak valid pada data index {$i}.'); window.history.back();</script>";
            exit;
        }

        // log transform
        $values[$i] = log(max(1, $clean));

        $jenis = $feat['properties']['JENIS_ZONA'] ?? null;
        if ($jenis === null || $jenis === '') {
            echo "<script>alert('JENIS_ZONA kosong pada data index {$i}.'); window.history.back();</script>";
            exit;
        }

        $trueSet[(string)$jenis] = true;
    }

    if (count($values) < 2) {
        echo "<script>alert('Data terlalu sedikit untuk clustering.'); window.history.back();</script>";
        exit;
    }

    $trueLabels = array_values(array_keys($trueSet));

    // set rentang K
    $RESTARTS = 15;
    $K_MIN    = max(2, count($trueLabels));
    $K_MAX    = max($K_MIN, min($K_MIN + 3, 8));

    $best = [
        'K' => null,
        'assign' => null,
        'mapping' => null,
        'accuracy' => -1,
        'counts' => null,
        'correct' => 0,
        'total' => 0
    ];

    for ($K = $K_MIN; $K <= $K_MAX; $K++) {
        $assign = kmeans1d_plusplus_best($values, $K, $RESTARTS, 120);
        $counts = build_counts($assign, $features, $trueLabels);
        $mapping = hungarian_mapping($counts, $trueLabels, $K);
        [$acc, $correct, $total] = compute_accuracy($assign, $features, $mapping);

        if ($acc > $best['accuracy']) {
            $best['K'] = $K;
            $best['assign'] = $assign;
            $best['mapping'] = $mapping;
            $best['accuracy'] = $acc;
            $best['counts'] = $counts;
            $best['correct'] = $correct;
            $best['total'] = $total;
        }
    }

    // hasil cluster disimpan ke file baru
    $outputFile = preg_replace('/\.geojson$/i', '_clustered.geojson', $geojson_file);
    if ($outputFile === $geojson_file) {
        $outputFile = $geojson_file . '.clustered.geojson';
    }

    foreach ($data['features'] as $i => &$feat) {
        $feat['properties']['cluster'] = $best['assign'][$i] ?? null;
    }
    unset($feat);

    file_put_contents($outputFile, json_encode($data));

    // simpan RELATIVE path ke database
    $folder_name = basename(dirname($outputFile));
    $output_db_path = "uploads/shapefiles/" . $folder_name . "/" . basename($outputFile);
    $output_db_path = str_replace('\\', '/', $output_db_path);

    $stmt = $conn->prepare("UPDATE shp_upload SET geojson_path = ? WHERE id = ?");
    $stmt->bind_param("si", $output_db_path, $id);
    $stmt->execute();

    // simpan summary dan confusion di folder yang sama
    $reportDir = dirname($outputFile);
    $ts = date('Ymd_His');

    $summaryFile = $reportDir . "/kmeans_eval_{$id}_{$ts}.txt";
    $csvFile     = $reportDir . "/kmeans_confusion_{$id}_{$ts}.csv";

    $summary = [];
    $summary[] = "K-MEANS (1D log(RPBULAT)) — AUTO-TUNE + KMEANS++ + HUNGARIAN";
    $summary[] = "Upload ID       : {$id}";
    $summary[] = "Input GeoJSON   : {$geojson_rel}";
    $summary[] = "Output GeoJSON  : {$output_db_path}";
    $summary[] = "Best K          : {$best['K']}";
    $summary[] = "Total features  : {$best['total']}";
    $summary[] = "Correct mapped  : {$best['correct']}";
    $summary[] = "Accuracy        : " . round($best['accuracy'] * 100, 2) . " %";
    $summary[] = "Mapping (cluster -> JENIS_ZONA):";
    foreach ($best['mapping'] as $c => $tLabel) {
        $summary[] = "  cluster {$c} => {$tLabel}";
    }

    file_put_contents($summaryFile, implode(PHP_EOL, $summary));

    $fp = fopen($csvFile, 'w');
    fputcsv($fp, ['pred_cluster', 'true_label', 'count']);
    foreach ($best['counts'] as $pred => $rowCount) {
        foreach ($rowCount as $t => $cnt) {
            fputcsv($fp, [$pred, $t, $cnt]);
        }
    }
    fclose($fp);

    $msg = "Clustering sukses!\\n"
        . "Best K: {$best['K']}\\n"
        . "Output: " . addslashes(basename($outputFile)) . "\\n"
        . "Accuracy (cluster→JENIS_ZONA): " . round($best['accuracy'] * 100, 2) . "%\\n"
        . "Summary: " . addslashes(basename($summaryFile)) . "\\n"
        . "Confusion: " . addslashes(basename($csvFile));

    echo "<script>alert('{$msg}'); window.location.href='?q=upload_zip';</script>";
    exit;
}

// ===================== Helper =====================

function build_counts(array $assign, array $features, array $trueLabels)
{
    $counts = [];
    foreach ($features as $i => $feat) {
        $pred = $assign[$i] ?? null;
        $true = $feat['properties']['JENIS_ZONA'] ?? null;
        if ($pred === null || $true === null) continue;

        $true = (string)$true;

        if (!isset($counts[$pred])) $counts[$pred] = [];
        if (!isset($counts[$pred][$true])) $counts[$pred][$true] = 0;
        $counts[$pred][$true]++;
    }

    foreach ($counts as $p => $row) {
        foreach ($trueLabels as $t) {
            if (!isset($counts[$p][$t])) $counts[$p][$t] = 0;
        }
        ksort($counts[$p]);
    }

    ksort($counts);
    return $counts;
}

function hungarian_mapping(array $counts, array $trueLabels, int $K)
{
    for ($p = 0; $p < $K; $p++) {
        if (!isset($counts[$p])) {
            $counts[$p] = array_fill_keys($trueLabels, 0);
        }
    }

    $cost = [];
    foreach (range(0, $K - 1) as $p) {
        $row = [];
        foreach ($trueLabels as $tIdx => $tLabel) {
            $cnt = $counts[$p][$tLabel] ?? 0;
            $row[$tIdx] = -$cnt;
        }
        $cost[$p] = $row;
    }

    $assignCols = hungarian($cost);
    $mapping = [];

    foreach ($assignCols as $p => $tIdx) {
        if ($tIdx !== null) {
            $mapping[$p] = $trueLabels[$tIdx];
        }
    }

    return $mapping;
}

function compute_accuracy(array $assign, array $features, array $mapping)
{
    $correct = 0;
    $total = 0;

    foreach ($features as $i => $feat) {
        $true = $feat['properties']['JENIS_ZONA'] ?? null;
        $pred = $assign[$i] ?? null;
        if ($true === null || $pred === null) continue;

        $mapped = $mapping[$pred] ?? null;
        if ($mapped !== null) {
            $total++;
            if ((string)$true === (string)$mapped) {
                $correct++;
            }
        }
    }

    $acc = $total ? ($correct / $total) : 0.0;
    return [$acc, $correct, $total];
}

function kmeans1d_plusplus_best(array $values, int $k, int $restarts = 10, int $maxIter = 100)
{
    $bestAssign = null;
    $bestInertia = INF;

    for ($r = 0; $r < $restarts; $r++) {
        [$assign, $inertia] = kmeans1d_plusplus_once($values, $k, $maxIter);
        if ($inertia < $bestInertia) {
            $bestInertia = $inertia;
            $bestAssign  = $assign;
        }
    }

    return $bestAssign;
}

function kmeans1d_plusplus_once(array $values, int $k, int $maxIter = 100)
{
    $idxs = array_keys($values);
    $n = count($idxs);
    if ($k > $n) $k = $n;

    $centroids = [];
    $first = $idxs[array_rand($idxs)];
    $centroids[] = $values[$first];

    while (count($centroids) < $k) {
        $d2 = [];
        $sum = 0.0;

        foreach ($idxs as $i) {
            $v = $values[$i];
            $minD = INF;

            foreach ($centroids as $c) {
                $d = ($v - $c);
                $d *= $d;
                if ($d < $minD) $minD = $d;
            }

            $d2[$i] = $minD;
            $sum += $minD;
        }

        if ($sum <= 0) {
            while (count($centroids) < $k) {
                $centroids[] = $centroids[0];
            }
            break;
        }

        $pick = weighted_pick($d2, $sum);
        $centroids[] = $values[$pick];
    }

    $assign = [];

    for ($iter = 0; $iter < $maxIter; $iter++) {
        $changed = false;

        foreach ($values as $i => $v) {
            $bestC = 0;
            $bestD = INF;

            foreach ($centroids as $cIdx => $cVal) {
                $d = $v - $cVal;
                $d *= $d;
                if ($d < $bestD) {
                    $bestD = $d;
                    $bestC = $cIdx;
                }
            }

            if (!isset($assign[$i]) || $assign[$i] !== $bestC) {
                $assign[$i] = $bestC;
                $changed = true;
            }
        }

        $sum = array_fill(0, $k, 0.0);
        $cnt = array_fill(0, $k, 0);

        foreach ($values as $i => $v) {
            $c = $assign[$i];
            $sum[$c] += $v;
            $cnt[$c]++;
        }

        for ($c = 0; $c < $k; $c++) {
            if ($cnt[$c] > 0) {
                $centroids[$c] = $sum[$c] / $cnt[$c];
            }
        }

        if (!$changed) break;
    }

    $inertia = 0.0;
    foreach ($values as $i => $v) {
        $c = $assign[$i];
        $d = $v - $centroids[$c];
        $inertia += $d * $d;
    }

    return [$assign, $inertia];
}

function weighted_pick(array $weights, float $sum)
{
    $r = mt_rand() / mt_getrandmax() * $sum;
    $acc = 0.0;

    foreach ($weights as $i => $w) {
        $acc += $w;
        if ($r <= $acc) return $i;
    }

    end($weights);
    return key($weights);
}

function hungarian(array $cost)
{
    $nRows = count($cost);
    $nCols = count($cost[0] ?? []);
    $n = max($nRows, $nCols);

    $a = array_fill(0, $n, array_fill(0, $n, 0.0));
    for ($i = 0; $i < $nRows; $i++) {
        for ($j = 0; $j < $nCols; $j++) {
            $a[$i][$j] = $cost[$i][$j];
        }
    }

    $u = array_fill(0, $n + 1, 0.0);
    $v = array_fill(0, $n + 1, 0.0);
    $p = array_fill(0, $n + 1, 0);
    $way = array_fill(0, $n + 1, 0);

    for ($i = 1; $i <= $n; $i++) {
        $p[0] = $i;
        $j0 = 0;
        $minv = array_fill(0, $n + 1, INF);
        $used = array_fill(0, $n + 1, false);

        do {
            $used[$j0] = true;
            $i0 = $p[$j0];
            $delta = INF;
            $j1 = 0;

            for ($j = 1; $j <= $n; $j++) {
                if ($used[$j]) continue;

                $cur = $a[$i0 - 1][$j - 1] - $u[$i0] - $v[$j];
                if ($cur < $minv[$j]) {
                    $minv[$j] = $cur;
                    $way[$j] = $j0;
                }

                if ($minv[$j] < $delta) {
                    $delta = $minv[$j];
                    $j1 = $j;
                }
            }

            for ($j = 0; $j <= $n; $j++) {
                if ($used[$j]) {
                    $u[$p[$j]] += $delta;
                    $v[$j] -= $delta;
                } else {
                    $minv[$j] -= $delta;
                }
            }

            $j0 = $j1;
        } while ($p[$j0] != 0);

        do {
            $j1 = $way[$j0];
            $p[$j0] = $p[$j1];
            $j0 = $j1;
        } while ($j0 != 0);
    }

    $ans = array_fill(0, $nRows, null);
    for ($j = 1; $j <= $nCols; $j++) {
        if ($p[$j] >= 1 && $p[$j] <= $nRows) {
            $ans[$p[$j] - 1] = $j - 1;
        }
    }

    return $ans;
}