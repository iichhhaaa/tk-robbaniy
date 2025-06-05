<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['nama'])) {
    // Redirect to login page if user is not authenticated
    header('Location: ../../../login.php');
    exit();
}

// Check if the user role is admin
if ($_SESSION['role'] !== 'admin') {
    // Redirect non-admin users to another dashboard
    header('Location: ../dashboard-capen/index.php');
    exit();
}

$nama = $_SESSION['nama'];
include '../../../koneksi.php'; // Load the database connection

// Retrieve data from the 'info_pendaftaran' table (if needed)
$sql = "SELECT * FROM info_pendaftaran";
$result = $conn->query($sql);

$row = $result->fetch_assoc();

$conn->close();
?>
<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Tambah Data Info Pendaftaran</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">

    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>

<body id="page-top">

    <!-- Main Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar Navigation -->
        <?php include '../inc/sidebar.php'; ?>

        <!-- Content Area Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content Area -->
            <div id="content">

                <!-- Top Navigation Bar -->
                <?php include '../inc/dashboard-header.php' ?>

                <!-- Main Container -->
                <div class="container-fluid">

                    <!-- Page Title -->
                    <h1 class="h3 mb-2 text-gray-800">Tambah Data Info Pendaftaran</h1>

                    <!-- Back Button -->
                    <a href="index.php" class="btn btn-primary mb-3">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>

                    <!-- Success Alert if Submission is Successful -->
                    <?php
                    if (isset($_GET['status']) && $_GET['status'] == 'success') {
                        echo "<div class='alert alert-success' role='alert'>
                                Data berhasil dibuat!
                              </div>";
                    }
                    ?>

                    <!-- Start of Form Card -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <form action="create-store.php" method="POST" enctype="multipart/form-data">

                                <!-- Input: Syarat Pendaftaran -->
                                <div class="mb-3">
                                    <label for="syarat_pendaftaran" class="form-label">Syarat Pendaftaran</label>
                                    <textarea class="form-control" id="syarat_pendaftaran" name="syarat_pendaftaran" rows="5" required></textarea>
                                </div>

                                <!-- Input: Biaya PPDB -->
                                <div class="mb-3">
                                    <label for="biaya_ppdb" class="form-label">Biaya PPDB</label>
                                    <textarea class="form-control" id="biaya_ppdb" name="biaya_ppdb" rows="5" required></textarea>
                                </div>

                                <!-- Submit Button -->
                                <button type="submit" class="btn btn-primary">Kirim</button>

                            </form>
                        </div>
                    </div>
                    <!-- End of Form Card -->

                </div>
                <!-- End of Main Container -->

            </div>
            <!-- End of Main Content Area -->

            <!-- Footer Section -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>&copy; <?= date('Y'); ?> TK Islam Robbaniy</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer Section -->

        </div>
        <!-- End of Content Area Wrapper -->

    </div>
    <!-- End of Main Page Wrapper -->

    <!-- Load JavaScript Dependencies -->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Load Main Script -->
    <script src="../js/sb-admin-2.min.js"></script>

    <!-- Load DataTables Plugin -->
    <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Load DataTables Demo -->
    <script src="../js/demo/datatables-demo.js"></script>

    <!-- Load Bootstrap 5 Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>