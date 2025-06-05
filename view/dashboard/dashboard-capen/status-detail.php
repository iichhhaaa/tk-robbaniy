<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['nama'])) {
    // If not logged in, redirect to login page
    header('Location: ../../../login.php');
    exit();
}


include '../../../koneksi.php';

// Ambil ID dari parameter URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Query untuk mengambil detail pendaftaran
$sql = "SELECT p.kode_pendaftaran, p.status, m.nama AS nama_murid, a.nama AS nama_ayah, i.nama AS nama_ibu
        FROM pendaftaran p
        JOIN murid m ON p.murid_id = m.id
        JOIN ayah a ON p.ayah_id = a.id
        JOIN ibu i ON p.ibu_id = i.id
        WHERE p.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

// Cek jika data tidak ditemukan
if (!$data) {
    echo "Data tidak ditemukan.";
    exit();
}

// Ambil status pendaftaran dari database
$status = $data['status'];

// Penjelasan langkah setelah diterima
$penjelasan = "";
if ($status === "Lolos") {
    $penjelasan = "
    <p><strong>Selamat, {$data['nama_murid']} dinyatakan <span class='text-success'>Lolos</span>!</strong></p>
    <p>Silakan lakukan pembayaran administrasi ke rekening berikut:</p>
    <ul>
        <li><strong>Bank:</strong> BCA</li>
        <li><strong>No. Rekening:</strong> 8682078255</li>
        <li><strong>Atas Nama:</strong> Tetik</li>
    </ul>
    <p>Setelah melakukan pembayaran, kirimkan bukti transfer ke WhatsApp: <strong>0812-9678-1234</strong>.</p>
    <p>Jika pembayaran telah dikonfirmasi, Anda akan segera diundang ke grup informasi siswa baru.</p>
";
} elseif ($status === "Tidak Lolos") {
    $penjelasan = "<p><strong>Mohon maaf, {$data['nama_murid']} <span class='text-danger'>Tidak Lolos</span> pada tahap pendaftaran.</strong> Terima kasih telah mendaftar.</p>";
} else {
    $penjelasan = "<p>Pendaftaran Anda sedang dalam proses verifikasi. Silakan cek kembali saat pengumuman hasil telah tersedia</p>";
}

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

    <title>Detail Status Pendaftaran</title>
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

    <!-- Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include '../inc/sidebar.php' ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include '../inc/dashboard-header.php' ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Detail Status Pendaftaran</h6>
                        </div>
                        <div class="card-body">
                            <p><strong>Kode Pendaftaran:</strong> <?php echo htmlspecialchars($data['kode_pendaftaran']); ?></p>
                            <p><strong>Nama Murid:</strong> <?php echo htmlspecialchars($data['nama_murid']); ?></p>
                            <p><strong>Nama Ayah:</strong> <?php echo htmlspecialchars($data['nama_ayah']); ?></p>
                            <p><strong>Nama Ibu:</strong> <?php echo htmlspecialchars($data['nama_ibu']); ?></p>
                            <p><strong>Status Pendaftaran:</strong>
                                <span class="badge badge-<?php
                                                            if ($status === "Lolos") {
                                                                echo "success";  // hijau
                                                            } elseif ($status === "Tidak Lolos") {
                                                                echo "danger";   // merah
                                                            } elseif ($status === "Sedang Verifikasi") {
                                                                echo "warning";  // kuning
                                                            }
                                                            ?>">
                                    <?php echo htmlspecialchars($status); ?>
                                </span>
                            </p>
                            <hr>
                            <?php echo $penjelasan; ?>
                        </div>
                        <div class="card-footer">
                            <a href="status.php" class="btn btn-secondary">Kembali</a>
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