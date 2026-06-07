<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php
    session_start();
    include 'conf/conf.php'; // Koneksi ke database

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = htmlspecialchars($_POST['email']);
        $password = $_POST['password'];

        // Cek apakah user ada
        $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($id, $name, $hashed_password);
        $stmt->fetch();

        if ($stmt->num_rows > 0) {
            if (password_verify($password, $hashed_password)) {
                $_SESSION['user_id'] = $id;
                $_SESSION['user_name'] = $name;
                echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Login Berhasil!',
                    text: 'Selamat datang, $name.',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = 'admin/index';
                });
            </script>";
            } else {
                echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Password salah!'
                }).then(() => {
                    window.location.href = 'index';
                });
            </script>";
            }
        } else {
            echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Email tidak ditemukan!'
            }).then(() => {
                window.location.href = 'index';
            });
        </script>";
        }
    }
    ?>
</body>

</html>