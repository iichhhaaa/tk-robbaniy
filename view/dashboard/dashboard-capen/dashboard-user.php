<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['nama'])) {
    // If not logged in, redirect to login page
    header('Location: login.php');
    exit();
}

include '../../../koneksi.php';

$sql = "SELECT * FROM pendaftaran";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$setting = "SELECT value FROM settings WHERE key_name = 'pendaftaran_status'";
$result_setting = $conn->query($setting);
$row_setting = $result_setting->fetch_assoc();
$status = $row_setting['value'];

$nama = $_SESSION['nama'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Dashboard User</title>

    <!-- Custom fonts for this template -->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body id="page-top">

    <div id="wrapper">
        <?php include '../inc/sidebar.php' ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include '../inc/dashboard-header.php' ?>

                <div class="container-fluid">
                    <h1 class="h3 mb-4 text-gray-800">Selamat Datang, <?php echo $nama; ?>!</h1>

                    <div class="row mt-4">
                        <!-- Content for user to follow steps -->
                        <div class="col-12">
                            <div class="card shadow mb-4">
                                    <div class="card-body">
                                        Status: <?php echo $row["status"] ?>
                                    </div>                       
                            </div>
                            
                            <div class="card shadow mb-4">
                                    <div class="card-body">
                                        <h4 class="card-title">Langkah-langkah Pengisian Form Berkas</h4>
                                        <p>Untuk melanjutkan proses pendaftaran, Anda perlu mengisi form berkas berikut:</p>
                                        <ol>
                                            <li><strong>Form Berkas KK (Kartu Keluarga):</strong> Silakan unduh dan lengkapi form berkas KK Anda.</li>
                                            <li><strong>Form Berkas Akte Kelahiran:</strong> Silakan unduh dan lengkapi form berkas Akte Kelahiran Anda.</li>
                                            <li><strong>Form Berkas KTP:</strong> Silakan unduh dan lengkapi form berkas KTP Anda.</li>
                                        </ol>
                                        <p>Setelah Anda mengisi semua form berkas di atas, gabungkan ketiganya dalam satu PDF untuk melanjutkan pendaftaran.</p>
                                        <p>Jika Anda telah selesai, silakan kirimkan berkas tersebut sesuai petunjuk yang akan diberikan pada tahap berikutnya.</p>
                                    </div>                       
                            </div>
                            
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="alert alert-info" role="alert">
                                Pastikan semua berkas telah digabungkan menjadi satu file PDF sebelum melanjutkan.
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->

        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>

</body>

</html>
