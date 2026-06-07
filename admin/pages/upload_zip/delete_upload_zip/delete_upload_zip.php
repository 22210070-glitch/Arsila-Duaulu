<?php
if ($_GET['q'] === 'delete_upload_zip' && isset($_GET['id'])) {
    $id = (int) $_GET['id'];

    // Ambil info file dari database
    $stmt = $conn->prepare("SELECT file_name FROM shp_upload WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($file_name);
    $stmt->fetch();
    $stmt->close();

    if ($file_name) {
        // Tentukan path lengkap ke file .zip dan folder hasil ekstrak
        $upload_dir = "uploads/shapefiles/";
        $zip_path = $upload_dir . $file_name;
        $extracted_folder = $upload_dir . pathinfo($file_name, PATHINFO_FILENAME);

        // Hapus file .zip
        if (file_exists($zip_path)) {
            unlink($zip_path);
        }

        // Hapus folder hasil ekstrak beserta isinya
        function deleteFolder($folder)
        {
            if (!file_exists($folder)) return;
            foreach (scandir($folder) as $file) {
                if ($file === '.' || $file === '..') continue;
                $filePath = "$folder/$file";
                is_dir($filePath) ? deleteFolder($filePath) : unlink($filePath);
            }
            rmdir($folder);
        }

        deleteFolder($extracted_folder);

        // Hapus dari database
        $conn->query("DELETE FROM shp_upload WHERE id = $id");

        echo "<script>alert('Data berhasil dihapus.'); window.location.href='?q=upload_zip';</script>";
    } else {
        echo "<script>alert('Data tidak ditemukan.'); window.history.back();</script>";
    }
}
