<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['nama'])) {
    // If not logged in, redirect to login page
    header('Location: ../../../login.php');
    exit();
}


include '../../../koneksi.php';

$user_id = $_SESSION['id'];

// Query untuk mengambil data pendaftaran yang relevan dengan pengguna yang login
$sql = "SELECT * FROM pendaftaran WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);  // Mengikat user_id sebagai parameter
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$setting = "SELECT value FROM settings WHERE key_name = 'pendaftaran_status'";
$result_setting = $conn->query($setting);
$row_setting = $result_setting->fetch_assoc();
$status = $row_setting['value'];

$nama = $_SESSION['nama'];
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Dashboard</title>
    <!-- Custom fonts for this template -->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>

<body id="page-top">

    <div id="wrapper">
        <?php include '../inc/sidebar.php' ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include '../inc/dashboard-header.php' ?>

                <div class="container-fluid">
                    <h1 class="h3 mb-4 text-gray-800">Selamat Datang, <?php echo $nama; ?>!</h1>

                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <h4 class="card-title">Langkah-langkah Pendaftaran</h4>
                            <p>Untuk melanjutkan proses pendaftaran, Anda perlu mengikuti langkah-langkah berikut:</p>
                            <ol>
                                <li>Siapkan berkas yang diperlukan
                                    <ul>
                                        <li>KK (Kartu Keluarga)</li>
                                        <li>Akte Kelahiran</li>
                                        <li>KTP</li>
                                    </ul>
                                </li>
                                <li>Gabungkan semua berkas - berkas KK, Akte Kelahiran, dan KTP dalam satu PDF</li>
                                <li>Setelah semua berkas siap, klik bagian <strong>"Pendaftaran"</strong> untuk memulai pengisian formulir pendaftaran.</li>
                                <li>Setelah Anda mengklik bagian pendaftaran, lengkapi formulir yang tersedia dengan informasi yang benar dan lengkap.</li>
                            </ol>
                            <p>Setelah mengisi formulir dan mengirimkan berkas, tunggu pengumuman hasil Anda pada bagian <strong>"Status"</strong> akan diperbarui setelah proses verifikasi selesai.</p>
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