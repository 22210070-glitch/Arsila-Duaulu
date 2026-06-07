<?php
if (isset($_GET['q']) && $_GET['q'] === 'delete_section1' && isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM section1_admin WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "
        <script>
        Swal.fire({
            icon: 'success',
            title: 'Dihapus!',
            text: 'Data berhasil dihapus.'
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
            text: 'Gagal menghapus data.'
        }).then(() => {
            window.location.href = '?q=section1';
        });
        </script>";
    }
}