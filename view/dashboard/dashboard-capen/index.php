<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['nama'])) {
    // If not logged in, redirect to login page
    header('Location: ../../../login.php');
    exit();
}

$nama = $_SESSION['nama'];
include '../../../koneksi.php';

$setting = "SELECT value FROM settings WHERE key_name = 'pendaftaran_status'";
$result_setting = $conn->query($setting);
$row_setting = $result_setting->fetch_assoc();
$status = $row_setting['value'];

$message_status = isset($_GET['status']) ? $_GET['status'] : null;


$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Dashboard - Pendaftaran</title>

    <!-- Custom fonts for this template -->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <?php include '../inc/sidebar.php'; ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <?php include '../inc/dashboard-header.php'; ?>


                <!-- Begin Page Content -->
                <div class="container-fluid">


                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">Pendaftaran Murid</h1>

                    <!-- Success/Error Message -->

                    <?php
                    if ($message_status) {
                        if ($message_status === 'success') {
                            echo "<div class='alert alert-success' role='alert'>Data berhasil diproses!</div>";
                        } elseif ($message_status === 'error') {
                            echo "<div class='alert alert-danger' role='alert'>Terjadi kesalahan saat memproses data.</div>";
                        }
                    }
                    ?>




                    <?php if ($status == 'open') { ?>

                        <!-- Button to add new data -->
                        <a href="pendaftaran.php" class="btn btn-primary mb-3">
                            <i class="fas fa-plus"></i> Daftar
                        </a>

                    <?php } ?>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Kode Pendaftaran</th>
                                            <th>Nama Murid</th>
                                            <th>Nama Ayah</th>
                                            <th>Nama Ibu</th>
                                            <th>Tindakan</th> <!-- Action column -->
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        // Connect to database
                                        include '../../../koneksi.php';

                                        // Get user_id from session
                                        $user_id = $_SESSION['id'];

                                        // Query to get data for the user, including related info from other tables
                                        $sql = "SELECT p.id, p.kode_pendaftaran, m.nama AS nama_murid, a.nama AS nama_ayah, i.nama AS nama_ibu
                                                FROM pendaftaran p
                                                JOIN murid m ON p.murid_id = m.id
                                                JOIN ayah a ON p.ayah_id = a.id
                                                JOIN ibu i ON p.ibu_id = i.id
                                                WHERE p.user_id = ?";  // Filter by user_id

                                        $stmt = $conn->prepare($sql);
                                        $stmt->bind_param("i", $user_id);  // Bind user_id to the query
                                        $stmt->execute();
                                        $result = $stmt->get_result();

                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<tr>";
                                                echo "<td>" . $row["kode_pendaftaran"] . "</td>";
                                                echo "<td>" . $row["nama_murid"] . "</td>";
                                                echo "<td>" . $row["nama_ayah"] . "</td>";
                                                echo "<td>" . $row["nama_ibu"] . "</td>";

                                                echo "<td>
                <div class='dropdown'>
                    <button class='btn btn-secondary btn-sm dropdown-toggle' type='button' id='dropdownMenuButton' data-bs-toggle='dropdown' aria-expanded='false'>
                        Aksi
                    </button>
                    <ul class='dropdown-menu' aria-labelledby='dropdownMenuButton'>";

                                                // Ekspor bisa selalu ditampilkan
                                                echo "<li><a class='dropdown-item' href='bukti.php?id=" . $row["id"] . "'>Ekspor</a></li>";

                                                // Edit dan Hapus hanya jika status open
                                                if ($status == 'open') {
                                                    echo "<li><a class='dropdown-item' href='update.php?id=" . $row["id"] . "'>Ubah</a></li>";
                                                    echo "<li><a class='dropdown-item text-danger' href='delete.php?id=" . $row["id"] . "' onclick='return confirm(\"Yakin ingin menghapus data ini?\")'>Hapus</a></li>";
                                                }


                                                echo "      
                                                </ul>
                                            </div>
                </td>";
                                                echo "</tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='5'>Data tidak ditemukan</td></tr>";
                                        }

                                        // Close connection
                                        $conn->close();
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <!-- <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2020</span>
                    </div>
                </div>
            </footer> -->
            <!-- End of Footer -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button -->
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

    <!-- Page level plugins -->
    <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../js/demo/datatables-demo.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

</body>

</html>