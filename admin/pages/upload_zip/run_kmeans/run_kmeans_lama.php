<?php
if ($_GET['q'] === 'run_kmeans' && isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $result = $conn->query("SELECT geojson_path FROM shp_upload WHERE id = $id");
    $row = $result ? $result->fetch_assoc() : null;

    if (!$row || empty($row['geojson_path'])) {
        echo "<script>alert('Path GeoJSON tidak ditemukan.'); window.history.back();</script>";
        exit;
    }

    $geojson_file = $row['geojson_path'];
    if (!file_exists($geojson_file)) {
        echo "<script>alert('File GeoJSON tidak ditemukan.'); window.history.back();</script>";
        exit;
    }

    $json = file_get_contents($geojson_file);
    $data = json_decode($json, true);

    if (!$data || !isset($data['features'])) {
        echo "<script>alert('Format GeoJSON tidak valid.'); window.history.back();</script>";
        exit;
    }

    $values = [];
    $clean_map = []; // untuk menyimpan pemetaan nilai asli ke bersih

    foreach ($data['features'] as $feat) {
        if (isset($feat['properties']['RPBULAT'])) {
            $raw = $feat['properties']['RPBULAT'];
            $clean = floatval(preg_replace('/[^0-9]/', '', $raw)); // buang Rp dan titik

            if ($clean > 0) {
                $values[] = $clean;
                $clean_map[$clean] = $raw;
            }
        }
    }

    if (empty($values)) {
        echo "<script>alert('Tidak ada nilai RPBULAT ditemukan untuk clustering.'); window.history.back();</script>";
        exit;
    }

    $clusters = kMeansClustering($values, 3);

    foreach ($data['features'] as &$feat) {
        $raw = $feat['properties']['RPBULAT'] ?? null;
        $clean = floatval(preg_replace('/[^0-9]/', '', $raw));
        if ($clean > 0 && isset($clusters[$clean])) {
            $feat['properties']['cluster'] = $clusters[$clean];
        }
    }

    file_put_contents($geojson_file, json_encode($data));
    echo "<script>alert('Clustering berhasil diterapkan!'); window.location.href='?q=upload_zip';</script>";
}
