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

$nama = $_SESSION['nama'];
include '../../../koneksi.php'; // Include the database connection file

// Check if 'id' is passed in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id']; // Get the 'id' parameter from the URL

    // Query to fetch the existing data from the database based on the 'id'
    $sql = "SELECT * FROM fasilitas WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        // Bind the 'id' parameter
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if record is found
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $nama_fasilitas = $row['nama'];
            $foto_fasilitas = $row['foto']; // Store the existing file name of the photo
        } else {
            // Redirect to the index page if the record is not found
            header("Location: index.php");
            exit();
        }

        $stmt->close();
    }
} else {
    // If 'id' is not passed, redirect to the index page
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Data Fasilitas</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body id="page-top">

    <div id="wrapper">
        <?php include '../inc/sidebar.php'; ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include '../inc/dashboard-header.php'; ?>

                <div class="container-fluid">
                    <h1 class="h3 mb-2 text-gray-800">Edit Data Fasilitas</h1>

                    <a href="index.php" class="btn btn-primary mb-3">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>

                    <!-- Display success message if the data is updated successfully -->
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
                                    <label for="nama" class="form-label">Nama</label>
                                    <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama_fasilitas; ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label for="foto" class="form-label">Foto</label>
                                    <input type="file" class="form-control" id="foto" name="foto">
                                    <p>Foto Saat Ini: <img src="../../../storage/fasilitas/<?php echo $foto_fasilitas; ?>" width="100"></p>
                                </div>

                                <button type="submit" class="btn btn-primary">Kirim</button>
                            </form>
                        </div>
                    </div>
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