<?php
include '../conf/conf.php';

$tahun_ini = date("Y");
$tahun_lalu = $tahun_ini - 1;

$bulan_ini = date("m");
$bulan_lalu = date("m", strtotime("-1 month"));
$tahun_bulan_lalu = date("Y", strtotime("-1 month"));

// Yearly
$sql_tahun_ini = "SELECT COUNT(*) as jumlah FROM shp_upload WHERE YEAR(uploaded_at) = $tahun_ini";
$sql_tahun_lalu = "SELECT COUNT(*) as jumlah FROM shp_upload WHERE YEAR(uploaded_at) = $tahun_lalu";

// Monthly
$sql_bulan_ini = "SELECT COUNT(*) as jumlah FROM shp_upload WHERE MONTH(uploaded_at) = $bulan_ini AND YEAR(uploaded_at) = $tahun_ini";
$sql_bulan_lalu = "SELECT COUNT(*) as jumlah FROM shp_upload WHERE MONTH(uploaded_at) = $bulan_lalu AND YEAR(uploaded_at) = $tahun_bulan_lalu";

// Eksekusi
$jumlah_tahun_ini = $conn->query($sql_tahun_ini)->fetch_assoc()['jumlah'];
$jumlah_tahun_lalu = $conn->query($sql_tahun_lalu)->fetch_assoc()['jumlah'];
$jumlah_bulan_ini = $conn->query($sql_bulan_ini)->fetch_assoc()['jumlah'];
$jumlah_bulan_lalu = $conn->query($sql_bulan_lalu)->fetch_assoc()['jumlah'];

// Hitung persentase
$growth_tahunan = ($jumlah_tahun_lalu > 0) ? round((($jumlah_tahun_ini - $jumlah_tahun_lalu) / $jumlah_tahun_lalu) * 100) : 100;
$growth_bulanan = ($jumlah_bulan_lalu > 0) ? round((($jumlah_bulan_ini - $jumlah_bulan_lalu) / $jumlah_bulan_lalu) * 100) : 100;

// Output JSON
$data = [
    "tahun_ini" => $jumlah_tahun_ini,
    "tahun_lalu" => $jumlah_tahun_lalu,
    "growth_tahunan" => $growth_tahunan,
    "bulan_ini" => $jumlah_bulan_ini,
    "bulan_lalu" => $jumlah_bulan_lalu,
    "growth_bulanan" => $growth_bulanan
];

header('Content-Type: application/json');
echo json_encode($data);