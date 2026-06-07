<?php
include 'conf/conf.php';

$result = $conn->query("SELECT geojson_path FROM shp_upload WHERE geojson_path IS NOT NULL ORDER BY uploaded_at DESC");
$paths = [];

while ($row = $result->fetch_assoc()) {
    $geojson = $row['geojson_path'];

    $clustered = preg_replace('/\.geojson$/i', '_clustered.geojson', $geojson);

    if (file_exists($clustered)) {
        $paths[] = 'admin/' . ltrim($clustered, '/');
    } else {
        $paths[] = 'admin/' . ltrim($geojson, '/');
    }
}

header('Content-Type: application/json');
echo json_encode($paths);