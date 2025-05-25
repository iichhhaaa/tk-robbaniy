<?php
session_start();
include 'koneksi.php'; // Pastikan koneksi ke database sudah benar
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Daftar Akun - TK Islam Robbaniy</title>

    <!-- Custom fonts for this template-->
    <link href="https://cdn.jsdelivr.net/npm/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="view/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="view/dashboard/css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body class="bg-primary">
    <div class="container-sm d-flex align-items-center justify-content-center" style="min-height: 100vh;">
        <div class="row justify-content-center w-100">
            <div class="col-xl-12 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <img src="assets/login.svg" class="col-lg-6 d-none d-lg-block bg-login-image" alt="Image description">
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Buat Akun!</h1>

                                        <!-- Pesan sukses -->
                                        <?php if (isset($_SESSION['message'])): ?>
                                            <div id="successMessage" class="alert alert-success" role="alert">
                                                <?php
                                                echo htmlspecialchars($_SESSION['message']);
                                                unset($_SESSION['message']);
                                                ?>
                                            </div>
                                        <?php endif; ?>

                                        <!-- Pesan pendaftaran tutup -->
                                        <?php if (isset($_SESSION['msg_pendaftaran'])): ?>
                                            <div id="registrationStatusMessage" class="alert alert-danger" role="alert">
                                                <?php
                                                echo htmlspecialchars($_SESSION['msg_pendaftaran']);
                                                unset($_SESSION['msg_pendaftaran']);
                                                ?>
                                            </div>
                                        <?php endif; ?>

                                        <!-- Pesan error validasi -->
                                        <?php
                                        if (isset($_SESSION['errors']) && count($_SESSION['errors']) > 0) {
                                            $errors = $_SESSION['errors'];
                                            echo '<div id="errorMessage" class="alert alert-danger" role="alert">';
                                            echo implode('<br>', array_map('htmlspecialchars', $errors));
                                            echo '</div>';
                                            unset($_SESSION['errors']);
                                        }
                                        ?>

                                        <!-- Form Registrasi -->
                                        <form method="POST" action="register-store.php" class="user">
                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-user" id="username" name="username" placeholder="Nama Pengguna" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-user" id="nama" name="nama" placeholder="Nama Lengkap" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="email" class="form-control form-control-user" id="exampleInputEmail" placeholder="Alamat Email" name="email" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="password" class="form-control form-control-user" id="password" placeholder="Kata Sandi" name="password" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="password" class="form-control form-control-user" id="confirm_password" placeholder="Ulangi Kata Sandi" name="confirm_password" required>
                                            </div>

                                            <button type="submit" class="btn btn-user btn-block text-white" style="background-color: #fbbf24; border-color: #fbbf24;">
                                                Daftar Akun
                                            </button>
                                        </form>
                                        <hr>
                                        <div class="text-center">
                                            <a class="small" href="login.php">Sudah punya akun? Login!</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Bootstrap core JavaScript-->
            <script src="https://cdn.jsdelivr.net/npm/jquery/jquery.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap/js/bootstrap.bundle.min.js"></script>

            <!-- Core plugin JavaScript-->
            <script src="https://cdn.jsdelivr.net/npm/jquery-easing/jquery.easing.min.js"></script>

            <!-- Custom scripts for all pages-->
            <script src="view/js/sb-admin-2.min.js"></script>

            <script>
                // Fungsi untuk menghilangkan pesan setelah 5 detik
                window.onload = function() {
                    const errorMsg = document.getElementById('errorMessage');
                    const successMsg = document.getElementById('successMessage');
                    const regStatusMsg = document.getElementById('registrationStatusMessage');

                    [errorMsg, successMsg, regStatusMsg].forEach(msg => {
                        if (msg) {
                            setTimeout(() => {
                                msg.style.transition = "opacity 0.5s ease";
                                msg.style.opacity = 0;
                                setTimeout(() => msg.remove(), 500);
                            }, 5000);
                        }
                    });
                };
            </script>
</body>

</html>