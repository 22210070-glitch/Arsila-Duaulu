<?php

if ($_GET['q'] === 'edit_section2' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $judul = $_POST['judul'];

    if ($_FILES['gambar']['name']) {
        $gambarPath = 'uploads/' . time() . '_' . $_FILES['gambar']['name'];
        move_uploaded_file($_FILES['gambar']['tmp_name'], $gambarPath);
        $conn->query("UPDATE panduan SET judul='$judul', gambar='$gambarPath' WHERE id=$id");
    } else {
        $conn->query("UPDATE panduan SET judul='$judul' WHERE id=$id");
    }

    // Update FAQ existing
    for ($i = 0; $i < count($_POST['faq_id_existing']); $i++) {
        $fid = $_POST['faq_id_existing'][$i];
        $pertanyaan = $_POST['faq_pertanyaan_existing'][$i];
        $jawaban = $_POST['faq_jawaban_existing'][$i];
        $conn->query("UPDATE panduan_item SET pertanyaan='$pertanyaan', jawaban='$jawaban', urutan=$i WHERE id=$fid");
    }

    // Tambah FAQ baru
    if (isset($_POST['faq_pertanyaan_baru']) && is_array($_POST['faq_pertanyaan_baru'])) {
        $start = isset($_POST['faq_pertanyaan_existing']) ? count($_POST['faq_pertanyaan_existing']) : 0;
        for ($j = 0; $j < count($_POST['faq_pertanyaan_baru']); $j++) {
            $p = $conn->real_escape_string($_POST['faq_pertanyaan_baru'][$j]);
            $jwb = $conn->real_escape_string($_POST['faq_jawaban_baru'][$j]);
            $conn->query("INSERT INTO panduan_item (panduan_id, pertanyaan, jawaban, urutan)
                      VALUES ($id, '$p', '$jwb', " . ($start + $j) . ")");
        }
    }


    echo "
    <script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: 'Data panduan berhasil diperbarui.'
    }).then(() => {
        window.location.href = '?q=section2';
    });
    </script>";
}