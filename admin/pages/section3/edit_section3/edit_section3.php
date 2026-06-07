<?php
if ($_GET['q'] === 'edit_section3' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['judul_item'])) {
        // Edit item keunggulan
        $id = $_POST['id'];
        $judul_item = $_POST['judul_item'];
        $deskripsi = $_POST['deskripsi'];
        $ikon = $_POST['ikon'];

        $conn->query("UPDATE keunggulan_item SET judul_item = '$judul_item', deskripsi = '$deskripsi', ikon = '$ikon' WHERE id = $id");

        echo "
        <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: 'Item keunggulan berhasil diperbarui.'
        }).then(() => {
            window.location.href = '?q=section3';
        });
        </script>";
    } elseif (isset($_POST['judul'])) {
        // Edit judul section
        $section_id = $_POST['section_id'];
        $judul = $_POST['judul'];
        $teks_footer = $_POST['teks_footer'];
        $link_footer = $_POST['link_footer'];

        $conn->query("UPDATE section_keunggulan SET judul = '$judul', teks_footer = '$teks_footer', link_footer = '$link_footer' WHERE id = $section_id");

        echo "
        <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: 'Section berhasil diperbarui.'
        }).then(() => {
            window.location.href = '?q=section3';
        });
        </script>";
    }
}