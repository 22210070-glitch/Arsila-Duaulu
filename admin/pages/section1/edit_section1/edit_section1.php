<?php
if (isset($_GET['q']) && $_GET['q'] === 'edit_section1' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $subtitle = $_POST['subtitle'];

    $stmt = $conn->prepare("UPDATE section1_admin SET title = ?, subtitle = ? WHERE id = ?");
    $stmt->bind_param("ssi", $title, $subtitle, $id);

    if ($stmt->execute()) {
        echo "
        <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: 'Data berhasil diperbarui.'
        }).then(() => {
            window.location.href = '?q=section1';
        });
        </script>";
    } else {
        echo "
        <script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: 'Gagal memperbarui data.'
        }).then(() => {
            window.location.href = '?q=section1';
        });
        </script>";
    }
}