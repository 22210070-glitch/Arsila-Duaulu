<?php
function kMeansClustering($data, $k = 3, $maxIterations = 100)
{
    $centroids = [];
    $clusters = [];

    // 🛠️ Ubah semua nilai ke float (penting!)
    $data = array_map('floatval', $data);

    // 1. Inisialisasi centroid awal
    $keys = array_rand($data, $k);
    foreach ((array) $keys as $key) {
        $centroids[] = $data[$key];
    }

    for ($i = 0; $i < $maxIterations; $i++) {
        $clusters = [];

        // 2. Assign data ke cluster terdekat
        foreach ($data as $value) {
            $minDist = INF;
            $closest = 0;
            foreach ($centroids as $j => $centroid) {
                $dist = abs($value - $centroid); // ✅ sekarang tidak error
                if ($dist < $minDist) {
                    $minDist = $dist;
                    $closest = $j;
                }
            }
            $clusters[$closest][] = $value;
        }

        // 3. Hitung ulang centroid
        $newCentroids = [];
        foreach ($clusters as $cluster) {
            $newCentroids[] = array_sum($cluster) / count($cluster);
        }

        // 4. Cek konvergensi
        if ($centroids === $newCentroids) break;
        $centroids = $newCentroids;
    }

    // 5. Buat mapping nilai ke cluster
    $valueToCluster = [];
    foreach ($clusters as $clusterId => $values) {
        foreach ($values as $v) {
            $valueToCluster[$v] = $clusterId;
        }
    }

    return $valueToCluster;
}
