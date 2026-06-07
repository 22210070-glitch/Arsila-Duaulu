<?php
include '../conf/conf.php';

$query = mysqli_query($conn, "
    SELECT 
        DATE_FORMAT(uploaded_at, '%b') AS bulan,
        COUNT(*) AS jumlah
    FROM shp_upload
    GROUP BY MONTH(uploaded_at), YEAR(uploaded_at)
    ORDER BY YEAR(uploaded_at), MONTH(uploaded_at)
");

$data = [];

while ($row = mysqli_fetch_assoc($query)) {
    $data[] = $row;
}

header('Content-Type: application/json');
echo json_encode($data);