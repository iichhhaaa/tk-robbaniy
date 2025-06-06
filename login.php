<?php
session_start();

include 'koneksi.php';

// Retrieve registration status from database
$setting = "SELECT value FROM settings WHERE key_name = 'pendaftaran_status'";
$result_setting = $conn->query($setting);
$row_setting = $result_setting->fetch_assoc();
$status = $row_setting['value'];

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Masuk Akun - TK Islam Robbaniy</title>

    <!-- Custom fonts for this template -->
    <link href="view/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet" />

    <!-- Custom styles for this template -->
    <link href="view/dashboard/css/sb-admin-2.min.css" rel="stylesheet" />
</head>

<body class="bg-primary">
    <div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh;">
        <!-- Outer Row -->
        <div class="row justify-content-center w-100">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <!-- Left side image for login page -->
                            <img src="assets/login.svg" class="col-lg-6 d-none d-lg-block bg-login-image" alt="Image description" />
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <!-- Greeting heading shown to user in Indonesian -->
                                        <h1 class="h4 text-gray-900 mb-4">Selamat Datang Kembali!</h1>
                                    </div>

                                    <!-- Display error message if 'error' parameter is set in URL -->
                                    <?php if (isset($_GET['error'])): ?>
                                        <div id="errorMessage" class="alert alert-danger" role="alert">
                                            <?php echo htmlspecialchars($_GET['error']); ?>
                                        </div>
                                    <?php endif; ?>

                                    <!-- Display registration message stored in session -->
                                    <?php
                                    if (isset($_SESSION['msg_pendaftaran'])) {
                                        echo "<div class='alert alert-danger' role='alert'>
                                            {$_SESSION['msg_pendaftaran']}
                                        </div>";
                                        unset($_SESSION['msg_pendaftaran']); // Remove message after displaying
                                    }
                                    ?>

                                    <div id="registrationMessage"></div>

                                    <!-- Login form -->
                                    <form class="user" method="POST" action="login-check.php">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" id="exampleInputusername" aria-describedby="usernameHelp" placeholder="Nama Pengguna" name="username" required />
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Kata Sandi" name="password" required />
                                        </div>
                                        <button type="submit" class="btn btn-user btn-block text-white" style="background-color: #fbbf24; border-color: #fbbf24;">
                                            Masuk
                                        </button>
                                    </form>

                                    <hr />
                                    <div class="text-center">
                                        <!-- "Forgot Password?" link triggers JavaScript alert -->
                                        <a href="#" class="small" onclick="showMessage();">Lupa Kata Sandi?</a>
                                    </div>
                                    <div class="text-center">
                                        <!-- "Create Account" link triggers registration status check -->
                                        <a class="small" href="#" onclick="checkRegistrationStatus();">Buat Akun!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap core JavaScript -->
    <script src="view/vendor/jquery/jquery.min.js"></script>
    <script src="view/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript -->
    <script src="view/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages -->
    <script src="view/js/sb-admin-2.min.js"></script>

    <script>
        // Show alert with password recovery instructions (message in Indonesian)
        function showMessage() {
            alert("Silakan kirim email ke admin@tk-robbaniy.com untuk pemulihan kata sandi. Pastikan untuk melampirkan nama pengguna Anda dalam email.");
        }

        // Check if registration is open or closed before redirecting
        function checkRegistrationStatus() {
            <?php if ($status == 'closed'): ?>
                // If registration is closed, show a message (in Indonesian)
                document.getElementById("registrationMessage").innerHTML = `
                    <div class="alert alert-danger" role="alert">
                        Pendaftaran sudah ditutup! silahkan hubungi pihak tk
                    </div>`;
            <?php else: ?>
                // If registration is open, redirect to registration page
                window.location.href = 'register.php';
            <?php endif; ?>
        }

        // Automatically remove error message after 5 seconds with fade out effect
        window.onload = function() {
            const errorMsg = document.getElementById('errorMessage');
            if (errorMsg) {
                setTimeout(() => {
                    errorMsg.style.transition = "opacity 0.5s ease";
                    errorMsg.style.opacity = 0;
                    setTimeout(() => errorMsg.remove(), 500);
                }, 5000);
            }
        };
    </script>

</body>

</html>
