<?php
if ($_GET['q'] === 'add_section3' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul_item = $_POST['judul_item'];
    $deskripsi = $_POST['deskripsi'];
    $ikon = $_POST['ikon'];
    $section_id = $_POST['section_id']; // ✅ ambil section_id

    // Ambil urutan terakhir untuk section tersebut
    $getMax = $conn->query("SELECT MAX(urutan) as max_urut FROM keunggulan_item WHERE section_id = $section_id")->fetch_assoc();
    $urutan = $getMax['max_urut'] + 1;

    // ✅ masukkan section_id ke query
    $query = "INSERT INTO keunggulan_item (section_id, judul_item, deskripsi, ikon, urutan) 
              VALUES ($section_id, '$judul_item', '$deskripsi', '$ikon', $urutan)";
    $conn->query($query);

    echo "
    <script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: 'Item keunggulan berhasil ditambahkan.'
    }).then(() => {
        window.location.href = '?q=section3';
    });
    </script>";
}