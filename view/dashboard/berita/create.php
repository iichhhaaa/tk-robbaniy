<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['nama'])) {
    // If not logged in, redirect to login page
    header('Location: ../../../login.php');
    exit();
}

if ($_SESSION['role'] !== 'admin') {
    // If user is not admin, redirect to dashboard
    header('Location: ../dashboard-capen/index.php');
    exit();
}

// Get user name from session
$nama = $_SESSION['nama'];

include '../../../koneksi.php';

// Optional: Fetch a record from berita table
$sql = "SELECT * FROM berita";
$result = $conn->query($sql);

$row = $result->fetch_assoc();

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tambah Data Berita</title>

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

    <!-- Page Container -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include '../inc/sidebar.php'; ?>

        <!-- Main Content Container -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar Navigation -->
                <?php include '../inc/dashboard-header.php'; ?>

                <!-- Main Page Content -->
                <div class="container-fluid">

                    <!-- Page Title -->
                    <h1 class="h3 mb-2 text-gray-800">Tambah Data Berita</h1>

                    <!-- Back Button -->
                    <a href="index.php" class="btn btn-primary mb-3">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>

                    <!-- Display success alert if data creation was successful -->
                    <?php
                    if (isset($_GET['status']) && $_GET['status'] == 'success') {
                        echo "<div class='alert alert-success' role='alert'>
                            Data berhasil ditambahkan!
                        </div>";
                    }
                    ?>

                    <!-- Start of News Submission Form -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <form action="create-store.php" method="POST" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="judul" class="form-label">Judul Berita</label>
                                    <input type="text" class="form-control" id="judul" name="judul" required>
                                </div>

                                <div class="mb-3">
                                    <label for="content" class="form-label">Isi Berita</label>
                                    <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="foto" class="form-label">Unggah Foto</label>
                                    <input type="file" class="form-control" id="foto" name="foto" required>
                                </div>

                                <div class="mb-3">
                                    <label for="created_at" class="form-label">Tanggal Berita</label>
                                    <input type="date" class="form-control" id="created_at" name="created_at" required>
                                </div>

                                <button type="submit" class="btn btn-primary">Kirim</button>
                            </form>
                        </div>
                    </div>
                    <!-- End of Form -->

                </div>
                <!-- End of Page Content -->
            </div>
            <!-- End of Main Content -->

            <!-- Footer Section -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>&copy; <?= date('Y'); ?> TK Islam Robbaniy</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Core JS Libraries -->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="../js/sb-admin-2.min.js"></script>

    <!-- DataTables Plugin (Optional) -->
    <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="../js/demo/datatables-demo.js"></script>

    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>