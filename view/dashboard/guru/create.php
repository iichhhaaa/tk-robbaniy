<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['nama'])) {
    // Redirect to login page if not authenticated
    header('Location: ../../../login.php');
    exit();
}

// Check if user is an admin
if ($_SESSION['role'] !== 'admin') {
    // Redirect non-admin users to the dashboard
    header('Location: ../dashboard-capen/index.php');
    exit();
}

// Get the logged-in user's name
$nama = $_SESSION['nama'];
include '../../../koneksi.php';

// Query to fetch teacher data if needed
$sql = "SELECT * FROM guru";
$result = $conn->query($sql);

$row = $result->fetch_assoc();
$conn->close();
?>

<!DOCTYPE html>
<html lang="id"> <!-- Changed language to Indonesian -->

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tambah Data Guru</title>

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

    <div id="wrapper">
        <?php include '../inc/sidebar.php'; ?>

        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">
                <?php include '../inc/dashboard-header.php'; ?>

                <div class="container-fluid">
                    <h1 class="h3 mb-2 text-gray-800">Tambah Data Guru</h1>

                    <a href="index.php" class="btn btn-primary mb-3">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>

                    <?php
                    // Show success alert if data was added successfully
                    if (isset($_GET['status']) && $_GET['status'] == 'success') {
                        echo "<div class='alert alert-success' role='alert'>Data berhasil ditambah!</div>";
                    }
                    ?>

                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <form action="create-store.php" method="POST" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama</label>
                                    <input type="text" class="form-control" id="nama" name="nama" required>
                                </div>

                                <div class="mb-3">
                                    <label for="jabatan" class="form-label">Jabatan</label>
                                    <input type="text" class="form-control" id="jabatan" name="jabatan" required>
                                </div>

                                <div class="mb-3">
                                    <label for="foto" class="form-label">Foto</label>
                                    <input type="file" class="form-control" id="foto" name="foto" required>
                                </div>

                                <button type="submit" class="btn btn-primary">Kirim</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>&copy; <?= date('Y'); ?> TK Islam Robbaniy</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery Easing plugin -->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for the admin template -->
    <script src="../js/sb-admin-2.min.js"></script>

    <!-- DataTables plugins -->
    <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- DataTables custom scripts -->
    <script src="../js/demo/datatables-demo.js"></script>

    <!-- Bootstrap Bundle CDN (optional redundant, but left as-is) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>