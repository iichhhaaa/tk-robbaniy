<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['nama'])) {
    // If user is not logged in, redirect to login page
    header('Location: ../../../login.php');
    exit();
}

// Check if user role is not admin
if ($_SESSION['role'] !== 'admin') {
    // If user role is not admin, redirect to dashboard page
    header('Location: ../dashboard-capen/index.php');
    exit();
}

// Get user's name from session
$nama = $_SESSION['nama'];
include '../../../koneksi.php';

// Run query to get all data from guru table
$sql = "SELECT * FROM guru";
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

    <title>Galeri - TK Islam Robbaniy</title>

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

    <!-- Page Wrapper -->
    <div id="wrapper">
        <?php include '../inc/sidebar.php' ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php include '../inc/dashboard-header.php' ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Create Button -->
                    <a href="create.php" class="btn btn-primary mb-3">
                        <i class="fas fa-plus"></i> Tambah Data Galeri
                    </a>

                    <!-- Success/Error Message -->
                    <?php
                    if (isset($_GET['status'])) {
                        $status = $_GET['status'];

                        // If deletion was successful, display success message
                        if ($status == 'success') {
                            echo "<div class='alert alert-success' role='alert'>
                                Data berhasil dihapus!
                            </div>";
                        } elseif ($status == 'error') {
                            // If deletion failed, display error message
                            echo "<div class='alert alert-danger' role='alert'>
                                Terjadi kesalahan saat menghapus data.
                            </div>";
                        }
                    }
                    ?>

                    <!-- DataTables Example -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Judul</th>
                                            <th>Foto</th>
                                            <th>Tindakan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        include '../../../koneksi.php';
                                        // Query to select all from galeri table
                                        $sql_galeri = "SELECT * FROM galeri";
                                        $result_galeri = $conn->query($sql_galeri);
                                        $no = 1;

                                        if ($result_galeri->num_rows > 0) {
                                            // Loop through each row in the galeri table
                                            while ($galeri = $result_galeri->fetch_assoc()) {
                                                echo "<tr>";
                                                echo "<td>" . $no++ . "</td>";
                                                echo "<td>" . $galeri['judul'] . "</td>";
                                                echo "<td><img src='../../../storage/galeri/" . $galeri['foto'] . "' width='100'></td>";
                                                echo "<td>
                                                    <div class='dropdown'>
                                                        <button class='btn btn-secondary btn-sm dropdown-toggle' type='button' id='dropdownMenuButton' data-bs-toggle='dropdown' aria-expanded='false'>
                                                            Aksi
                                                        </button>
                                                        <ul class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                                                            <li><a class='dropdown-item' href='update.php?id=" . $galeri["id"] . "'>Ubah</a></li>
                                                            <li><a class='dropdown-item text-danger' href='delete.php?id=" . $galeri["id"] . "' onclick='confirmDelete(" . $galeri["id"] . ")'>Hapus</a></li>
                                                        </ul>
                                                    </div>
                                                </td>";
                                                echo "</tr>";
                                            }
                                        } else {
                                            // Display message if no gallery data is found
                                            echo "<tr><td colspan='4'>Data galeri tidak ditemukan.</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

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
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Siap untuk Keluar?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Pilih "Logout" di bawah jika Anda siap mengakhiri sesi saat ini.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../js/demo/datatables-demo.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>