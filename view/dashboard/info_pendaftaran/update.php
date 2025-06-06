<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['nama'])) {
    // Redirect to login page if user is not logged in
    header('Location: ../../../login.php');
    exit();
}

if ($_SESSION['role'] !== 'admin') {
    // Redirect to dashboard if user role is not admin
    header('Location: ../dashboard-capen/index.php');
    exit();
}

$nama = $_SESSION['nama'];
include '../../../koneksi.php'; // Include the database connection file

// Check if 'id' parameter is provided in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id']; // Get the 'id' from URL

    // Prepare SQL query to fetch the record with the given 'id'
    $sql = "SELECT * FROM info_pendaftaran WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        // Bind 'id' as integer parameter
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Verify if the record exists
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $syarat_pendaftaran = $row['syarat_pendaftaran'];
            $biaya_ppdb = $row['biaya_ppdb'];
        } else {
            // Redirect to index page if no record found
            header("Location: index.php");
            exit();
        }

        $stmt->close();
    }
} else {
    // Redirect to index page if 'id' is missing in URL
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ubah Data Info Pendaftaran</title>

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
                    <h1 class="h3 mb-2 text-gray-800">Ubah Data Info Pendaftaran</h1>

                    <a href="index.php" class="btn btn-primary mb-3">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>

                    <!-- Display success message if data is updated successfully -->
                    <?php
                    if (isset($_GET['status']) && $_GET['status'] == 'success') {
                        echo "<div class='alert alert-success' role='alert'>Data berhasil diperbarui!</div>";
                    }
                    ?>

                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <form action="update-store.php" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?php echo $id; ?>">

                                <div class="mb-3">
                                    <label for="syarat_pendaftaran" class="form-label">Syarat Pendaftaran</label>
                                    <textarea class="form-control" id="syarat_pendaftaran" name="syarat_pendaftaran" rows="5" required><?php echo $syarat_pendaftaran; ?></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="biaya_ppdb" class="form-label">Biaya PPDB</label>
                                    <textarea class="form-control" id="biaya_ppdb" name="biaya_ppdb" rows="5" required><?php echo $biaya_ppdb; ?></textarea>
                                </div>

                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
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