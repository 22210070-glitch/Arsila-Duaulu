<?php
if (isset($_GET['q']) && $_GET['q'] === 'add_section1' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $subtitle = $_POST['subtitle'];

    $stmt = $conn->prepare("INSERT INTO section1_admin (title, subtitle) VALUES (?, ?)");
    $stmt->bind_param("ss", $title, $subtitle);

    if ($stmt->execute()) {
        echo "
        <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: 'Data berhasil ditambahkan.'
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
            text: 'Gagal menambahkan data.'
        }).then(() => {
            window.location.href = '?q=section1';
        });
        </script>";
    }
}