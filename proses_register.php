<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php
    session_start();
    include 'conf/conf.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name     = trim($_POST['name'] ?? '');
        $email    = trim($_POST['email'] ?? '');
        $pass_raw = $_POST['password'] ?? '';
        $confirm  = $_POST['confirm_password'] ?? '';

        if ($name === '' || $email === '' || $pass_raw === '') {
            echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Semua field wajib diisi!'
            }).then(() => {
                window.location.href = 'index';
            });
        </script>";
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Format email tidak valid!'
            }).then(() => {
                window.location.href = 'index';
            });
        </script>";
            exit;
        }

        if (strlen($pass_raw) < 6) {
            echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Password minimal 6 karakter!'
            }).then(() => {
                window.location.href = 'index';
            });
        </script>";
            exit;
        }

        // Jalankan validasi ini jika form kamu memang punya input confirm_password
        if (isset($_POST['confirm_password']) && $pass_raw !== $confirm) {
            echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Konfirmasi password tidak cocok!'
            }).then(() => {
                window.location.href = 'index';
            });
        </script>";
            exit;
        }

        // Cek apakah email sudah terdaftar
        $checkEmail = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $checkEmail->bind_param("s", $email);
        $checkEmail->execute();
        $checkEmail->store_result();

        if ($checkEmail->num_rows > 0) {
            $checkEmail->close();

            echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Email sudah digunakan!'
            }).then(() => {
                window.location.href = 'index';
            });
        </script>";
            exit;
        }
        $checkEmail->close();

        $password = password_hash($pass_raw, PASSWORD_DEFAULT);

        // Simpan user ke database
        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $password);

        if ($stmt->execute()) {
            $stmt->close();
            $conn->close();

            echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Registrasi Berhasil!',
                text: 'Silakan login dengan akun Anda.',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = 'index';
            });
        </script>";
            exit;
        } else {
            $stmt->close();
            $conn->close();

            echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Gagal mendaftar, coba lagi.'
            }).then(() => {
                window.location.href = 'index';
            });
        </script>";
            exit;
        }
    } else {
        header("Location: index");
        exit;
    }
    ?>
</body>

</html>