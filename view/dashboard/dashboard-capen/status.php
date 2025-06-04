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

// Query to retrieve registration data relevant to the logged-in user
$sql = "SELECT p.id, p.kode_pendaftaran, p.status, m.nama AS nama_murid, a.nama AS nama_ayah, i.nama AS nama_ibu
        FROM pendaftaran p
        JOIN murid m ON p.murid_id = m.id
        JOIN ayah a ON p.ayah_id = a.id
        JOIN ibu i ON p.ibu_id = i.id
        WHERE p.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id); // Bind user_id as parameter
$stmt->execute();
$result = $stmt->get_result();

// Retrieve registration status setting from settings table
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

    <title>Status</title>
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
                    <!-- Display cards for each registered student -->
                    <div class="row">
                        <?php
                        while ($row = $result->fetch_assoc()) {
                        ?>
                            <div class="col-md-4 mb-4 d-flex align-items-stretch">
                                <div class="card shadow h-100 w-100">
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title"><?php echo htmlspecialchars($row['nama_murid']); ?></h5>
                                        <p class="card-text">Kode pendaftaran : <?php echo htmlspecialchars($row['kode_pendaftaran']); ?></p>
                                        <div class="mt-auto">
                                            <a href="status-detail.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm w-100">Cek</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
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