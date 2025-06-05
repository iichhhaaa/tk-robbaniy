<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['nama'])) {
    // If the user is not logged in, redirect to the login page
    header('Location: ../../../login.php');
    exit();
}

// Check if the user's role is not admin
if ($_SESSION['role'] !== 'admin') {
    // If the user is not an admin, redirect to the dashboard
    header('Location: ../dashboard-capen/index.php');
    exit();
}

// Get the user's name from the session
$nama = $_SESSION['nama'];
include '../../../koneksi.php'; // Connect to the database

// Check if 'id' parameter is provided in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id']; // Get the 'id' value from URL

    // Prepare query to fetch the record based on the provided id
    $sql = "SELECT * FROM galeri WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        // Bind the 'id' parameter to the query
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if any record is found
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $judul = $row['judul'];
            $foto = $row['foto']; // Store the current photo filename
        } else {
            // If no record is found, redirect back to index page
            header("Location: index.php");
            exit();
        }

        $stmt->close();
    }
} else {
    // If 'id' is not provided in the URL, redirect to index page
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id"> <!-- Change the language to Indonesian -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ubah Data Galeri</title>

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
                    <h1 class="h3 mb-2 text-gray-800">Ubah Data Galeri</h1>

                    <!-- Back Button -->
                    <a href="index.php" class="btn btn-primary mb-3">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>

                    <!-- Display success message if data update was successful -->
                    <?php
                    if (isset($_GET['status']) && $_GET['status'] == 'success') {
                        echo "<div class='alert alert-success' role='alert'>
                                Data berhasil diubah!
                              </div>";
                    }
                    ?>

                    <!-- Form Start -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <!-- Form submission is handled by update-store.php -->
                            <form action="update-store.php" method="POST" enctype="multipart/form-data">
                                <!-- Hidden input to pass the ID -->
                                <input type="hidden" name="id" value="<?php echo $id; ?>">

                                <div class="mb-3">
                                    <label for="judul" class="form-label">Judul</label>
                                    <!-- Populate title field with current value -->
                                    <input type="text" class="form-control" id="judul" name="judul" value="<?php echo $judul; ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label for="foto" class="form-label">Foto</label>
                                    <input type="file" class="form-control" id="foto" name="foto">
                                    <!-- Show the current photo -->
                                    <p>Foto Saat Ini: <img src="../../../storage/galeri/<?php echo $foto; ?>" width="100"></p>
                                </div>

                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </form>
                        </div>
                    </div>
                    <!-- End of Form -->

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
