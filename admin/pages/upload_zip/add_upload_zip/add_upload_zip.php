<?php
if (($_GET['q'] ?? '') === 'add_upload_zip' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = trim($_POST['judul'] ?? '');
    $file  = $_FILES['shapefile_zip'] ?? null;

    if ($judul === '') {
        echo "<script>alert('Judul wajib diisi.'); window.history.back();</script>";
        exit;
    }

    if (!$file) {
        echo "<script>alert('File ZIP tidak ditemukan.'); window.history.back();</script>";
        exit;
    }

    if ($file['error'] !== UPLOAD_ERR_OK) {
        $msg = 'Upload file gagal. ';
        switch ($file['error']) {
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                $msg .= 'Ukuran file melebihi batas upload server.';
                break;
            case UPLOAD_ERR_PARTIAL:
                $msg .= 'File hanya terupload sebagian.';
                break;
            case UPLOAD_ERR_NO_FILE:
                $msg .= 'Tidak ada file yang dipilih.';
                break;
            default:
                $msg .= 'Kode error: ' . $file['error'];
                break;
        }

        echo "<script>alert(" . json_encode($msg) . "); window.history.back();</script>";
        exit;
    }

    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if ($ext !== 'zip') {
        echo "<script>alert('Format file harus .zip'); window.history.back();</script>";
        exit;
    }

    // Tetap pakai path lama yang sudah terbukti jalan
    $upload_dir = "uploads/shapefiles/";
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    if (!is_writable($upload_dir)) {
        echo "<script>alert('Folder uploads/shapefiles tidak bisa ditulis.'); window.history.back();</script>";
        exit;
    }

    $safeName   = preg_replace('/[^A-Za-z0-9_\-\.]/', '_', basename($file['name']));
    $file_name  = time() . "_" . $safeName;
    $target_path = $upload_dir . $file_name;

    if (!move_uploaded_file($file['tmp_name'], $target_path)) {
        echo "<script>alert('Gagal upload file.'); window.history.back();</script>";
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO shp_upload (judul, file_name) VALUES (?, ?)");
    $stmt->bind_param("ss", $judul, $file_name);
    $stmt->execute();
    $id_upload = $conn->insert_id;

    $extract_folder = pathinfo($file_name, PATHINFO_FILENAME);
    $extract_dir = $upload_dir . $extract_folder;

    if (!is_dir($extract_dir)) {
        mkdir($extract_dir, 0777, true);
    }

    $zip = new ZipArchive;
    if ($zip->open($target_path) === TRUE) {
        $zip->extractTo($extract_dir);
        $zip->close();
    } else {
        echo "<script>alert('Gagal mengekstrak file ZIP'); window.history.back();</script>";
        exit;
    }

    // Cari file .shp secara rekursif agar tetap jalan walau ada subfolder di dalam ZIP
    $shp_file = '';
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($extract_dir, RecursiveDirectoryIterator::SKIP_DOTS)
    );

    foreach ($iterator as $item) {
        if (strtolower($item->getExtension()) === 'shp') {
            $shp_file = str_replace('\\', '/', $item->getPathname());
            break;
        }
    }

    if (!$shp_file) {
        echo "<script>alert('File .shp tidak ditemukan.'); window.history.back();</script>";
        exit;
    }

    $geojson_file = $extract_dir . '/result.geojson';

    // Pakai full path QGIS ogr2ogr
    $ogr2ogr = '"C:\\Program Files\\QGIS 3.44.9\\bin\\ogr2ogr.exe"';
    $cmd = $ogr2ogr
        . " -f GeoJSON "
        . escapeshellarg($geojson_file)
        . " "
        . escapeshellarg($shp_file)
        . " -t_srs EPSG:4326 2>&1";

    exec($cmd, $output, $return_code);

    if ($return_code === 0 && file_exists($geojson_file)) {
        // Simpan RELATIVE path ke database, bukan absolute path Windows
        $geojson_db_path = $extract_dir . '/result.geojson';
        $geojson_db_path = str_replace('\\', '/', $geojson_db_path);

        $stmt = $conn->prepare("UPDATE shp_upload SET geojson_path = ? WHERE id = ?");
        $stmt->bind_param("si", $geojson_db_path, $id_upload);
        $stmt->execute();

        echo "<script>
            if (confirm('Berhasil upload dan konversi shapefile! Ingin langsung jalankan clustering?')) {
                window.location.href='?q=run_kmeans&id=$id_upload';
            } else {
                window.location.href='?q=upload_zip';
            }
        </script>";
        exit;
    } else {
        $err = implode("\\n", $output);
        echo "<script>alert('Konversi .shp ke .geojson gagal. Detail: ' + " . json_encode($err) . "); window.history.back();</script>";
        exit;
    }
}