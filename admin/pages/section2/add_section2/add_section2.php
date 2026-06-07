<?php
if ($_GET['q'] === 'add_section2' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = $_POST['judul'];
    $gambarPath = 'uploads/' . time() . '_' . $_FILES['gambar']['name'];
    move_uploaded_file($_FILES['gambar']['tmp_name'], $gambarPath);

    $conn->query("INSERT INTO panduan (judul, gambar) VALUES ('$judul', '$gambarPath')");
    $panduan_id = $conn->insert_id;

    for ($i = 0; $i < count($_POST['faq_pertanyaan_baru']); $i++) {
        $p = $_POST['faq_pertanyaan_baru'][$i];
        $j = $_POST['faq_jawaban_baru'][$i];
        $conn->query("INSERT INTO panduan_item (panduan_id, pertanyaan, jawaban, urutan) VALUES ($panduan_id, '$p', '$j', $i)");
    }

    echo "
    <script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: 'Data panduan berhasil ditambahkan.'
    }).then(() => {
        window.location.href = '?q=section2';
    });
    </script>";
}