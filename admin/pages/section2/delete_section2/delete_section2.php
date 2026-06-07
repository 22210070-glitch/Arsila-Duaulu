<?php
if ($_GET['q'] === 'delete_section2' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $conn->query("DELETE FROM panduan WHERE id = $id");

    echo "
    <script>
    Swal.fire({
        icon: 'success',
        title: 'Terhapus!',
        text: 'Data panduan berhasil dihapus.'
    }).then(() => {
        window.location.href = '?q=section2';
    });
    </script>";
}