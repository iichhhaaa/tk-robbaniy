<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['nama'])) {
    // If not logged in, redirect to login page
    header('Location: ../../../login.php');
    exit();
}

if ($_SESSION['role'] !== 'admin') {
    // If not logged in or role is not admin, redirect to dashboard
    header('Location: ../dashboard-capen/index.php');
    exit();
}

// Get the user's name from the session
$nama = $_SESSION['nama'];
include '../../../koneksi.php';
// Run query to fetch one data from profile table
$sql = "SELECT * FROM pendaftaran";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$setting = "SELECT value FROM settings WHERE key_name = 'pendaftaran_status'";
$result_setting = $conn->query($setting);
$row_setting = $result_setting->fetch_assoc();
$status = $row_setting['value'];

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Pendaftaran - TK Islam Robbaniy</title>

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

                    <!-- Check if status is passed and show alert -->
                    <?php
                    if (isset($_GET['status']) && $_GET['status'] == 'success') {
                        echo "<div class='alert alert-success' role='alert' id='success-alert'>
                                Data berhasil diperbarui!
                              </div>";
                    }
                    ?>

                    <form id="pendaftaran-form">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="pendaftaran_status" class="form-label">
                                        Pendaftaran:
                                    </label>
                                    <!-- Toggle switch -->
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="pendaftaran_status"
                                            <?php echo ($status == 'open') ? 'checked' : ''; ?>>
                                        <label class="custom-control-label" for="pendaftaran_status">
                                            <?php echo ($status == 'open') ? 'Buka' : 'Tutup'; ?>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Create Button -->
                    <a href="create.php" class="btn btn-primary mb-3">
                        <i class="fas fa-plus"></i> Tambah Data Pendaftaran
                    </a>

                    <!-- DataTable Example -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kode Pendaftaran</th>
                                            <th>Murid</th>
                                            <th>Ayah</th>
                                            <th>Ibu</th>
                                            <th>Status</th>
                                            <th>Tindakan</th> <!-- Column for actions -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        include '../../../koneksi.php';

                                        // Query to fetch data from pendaftaran table
                                        $sql_pendaftaran = "SELECT pendaftaran.id, pendaftaran.kode_pendaftaran, pendaftaran.status, murid.nama AS murid_nama, ayah.nama AS ayah_nama, ibu.nama AS ibu_nama 
                                                        FROM pendaftaran
                                                        JOIN murid ON pendaftaran.murid_id = murid.id
                                                        JOIN ayah ON pendaftaran.ayah_id = ayah.id
                                                        JOIN ibu ON pendaftaran.ibu_id = ibu.id";

                                        $result_pendaftaran = $conn->query($sql_pendaftaran);
                                        $no = 1;

                                        if ($result_pendaftaran->num_rows > 0) {
                                            while ($pendaftaran = $result_pendaftaran->fetch_assoc()) {
                                                echo "<tr>";
                                                echo "<td>" . $no++ . "</td>";
                                                echo "<td>" . $pendaftaran['kode_pendaftaran'] . "</td>";
                                                echo "<td>" . $pendaftaran['murid_nama'] . "</td>";
                                                echo "<td>" . $pendaftaran['ayah_nama'] . "</td>";
                                                echo "<td>" . $pendaftaran['ibu_nama'] . "</td>";
                                                echo "<td>
                                                            <select class='form-control status-dropdown' data-id='" . $pendaftaran['id'] . "'>
                                                                <option value='Sedang Verifikasi' " . ($pendaftaran['status'] == 'Sedang Verifikasi' ? 'selected' : '') . ">Sedang Verifikasi</option>
                                                                <option value='Lolos' " . ($pendaftaran['status'] == 'Lolos' ? 'selected' : '') . ">Lolos</option>
                                                                <option value='Tidak Lolos' " . ($pendaftaran['status'] == 'Tidak Lolos' ? 'selected' : '') . ">Tidak Lolos</option>
                                                            </select>
                                                        </td>";
                                                echo "<td>
                                                    <div class='dropdown'>
                                                        <button class='btn btn-secondary btn-sm dropdown-toggle' type='button' id='dropdownMenuButton' data-bs-toggle='dropdown' aria-expanded='false'>
                                                            Aksi
                                                        </button>
                                                        <ul class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                                                            <li><a class='dropdown-item' href='view.php?id=" . $pendaftaran["id"] . "'>Lihat</a></li>
                                                            <li><a class='dropdown-item' href='update.php?id=" . $pendaftaran["id"] . "'>Ubah</a></li>
                                                            <li><a class='dropdown-item' href='bukti-pendaftaran.php?id=" . $pendaftaran["id"] . "'>Ekspor</a></li>
                                                            <li><a class='dropdown-item text-danger' href='delete.php?id=" . $pendaftaran["id"] . "' onclick='confirmDelete(" . $pendaftaran["id"] . ")'>Hapus</a></li>
                                                        </ul>
                                                    </div>
                                                </td>";
                                                echo "</tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='7'>Data pendaftaran tidak ditemukan.</td></tr>";
                                        }

                                        $conn->close();
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <a href="export.php" class="btn btn-success mb-3">
                        <i class="fas fa-file-export"></i> Ekspor ke CSV
                    </a>

                    <a href="export-excel.php" class="btn btn-success mb-3">
                        <i class="fas fa-file-export"></i> Ekspor ke Excel
                    </a>
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

    <!-- Page level plugins -->
    <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../js/demo/datatables-demo.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom scripts -->
    <script>
        $(document).ready(function () {
            // Send updated registration status using AJAX when the switch value changes
            $('#pendaftaran_status').change(function () {
                var new_status = $(this).prop('checked') ? 'open' : 'closed'; // Get the switch status

                // Make AJAX request to update status in the database
                $.ajax({
                    url: 'update-status.php', // PHP file to handle status update
                    type: 'POST',
                    data: {
                        pendaftaran_status: new_status
                    },
                    success: function (response) {
                        window.location.href = "?status=success"; // Redirect with success parameter
                    },
                    error: function () {
                        alert('Terjadi kesalahan saat memperbarui status.');
                    }
                });
            });

            // Send updated registration status using AJAX when the dropdown value changes
            $('.status-dropdown').change(function () {
                var new_status = $(this).val(); // Get the new status value
                var pendaftaran_id = $(this).data('id'); // Get the registration id

                // Make AJAX request to update status in the database
                $.ajax({
                    url: 'update-status.php', // PHP file to handle status update
                    type: 'POST',
                    data: {
                        pendaftaran_id: pendaftaran_id,
                        pendaftaran_status: new_status
                    },
                    success: function (response) {
                        // Success: Optionally update the status column or show a message
                       window.location.href = "?status=success";
                    },
                    error: function () {
                        alert('Terjadi kesalahan saat memperbarui status.');
                    }
                });
            });

            // Initialize DataTables plugin
            $('#dataTable').DataTable();

            // Hide the success alert after 5 seconds
            setTimeout(function () {
                $('#success-alert').fadeOut('slow');
            }, 5000); // 5000 ms = 5 seconds
        });
    </script>

</body>

</html>