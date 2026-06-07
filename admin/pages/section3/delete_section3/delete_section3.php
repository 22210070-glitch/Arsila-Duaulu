<?php
if ($_GET['q'] === 'delete_section3' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $conn->query("DELETE FROM keunggulan_item WHERE id = $id");

    echo "
    <script>
    Swal.fire({
        icon: 'success',
        title: 'Terhapus!',
        text: 'Item keunggulan berhasil dihapus.'
    }).then(() => {
        window.location.href = '?q=section3';
    });
    </script>";
}