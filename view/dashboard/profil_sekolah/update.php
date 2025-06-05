<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['nama'])) {
    // If not logged in, redirect to login page
    header('Location: ../../../login.php');
    exit();
}

// Check if the user role is 'admin'
if ($_SESSION['role'] !== 'admin') {
    // If role is not admin, redirect to dashboard
    header('Location: ../dashboard-capen/index.php');
    exit();
}

$nama = $_SESSION['nama'];
include '../../../koneksi.php'; // Include the database connection file

// Check if 'id' parameter exists in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id']; // Get the 'id' parameter from the URL

    // Prepare SQL query to select the record with the specified 'id'
    $sql = "SELECT * FROM profil_sekolah WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        // Bind 'id' parameter to the prepared statement
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if a record is found
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // Assign the retrieved data to variables
            $deskripsi = $row['deskripsi'];
            $visi = $row['visi'];
            $misi = $row['misi'];
            $alamat = $row['alamat'];
            $email = $row['email'];
            $no_telepon = $row['no_telepon'];
            $foto = $row['foto']; // Store the current photo filename
        } else {
            // Redirect to index if no matching record found
            header("Location: index.php");
            exit();
        }

        $stmt->close();
    }
} else {
    // Redirect to index if 'id' is not provided
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Ubah Data Profil Sekolah</title>

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
                    <h1 class="h3 mb-2 text-gray-800">Ubah Data Profil Sekolah</h1>

                    <a href="index.php" class="btn btn-primary mb-3">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>

                    <!-- Show success alert if data updated successfully -->
                    <?php
                    if (isset($_GET['status']) && $_GET['status'] == 'success') {
                        // User-facing success message in Indonesian
                        echo "<div class='alert alert-success' role='alert'>Data berhasil diperbarui!</div>";
                    }
                    ?>

                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <!-- Form for updating school profile -->
                            <form action="update-store.php" method="POST" enctype="multipart/form-data">
                                <!-- Hidden input to hold the record ID -->
                                <input type="hidden" name="id" value="<?php echo $id; ?>" />

                                <div class="mb-3">
                                    <label for="deskripsi" class="form-label">Deskripsi</label>
                                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="6" required><?php echo $deskripsi; ?></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="visi" class="form-label">Visi</label>
                                    <textarea class="form-control" id="visi" name="visi" required><?php echo $visi; ?></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="misi" class="form-label">Misi</label>
                                    <textarea class="form-control" id="misi" name="misi" rows="6" required><?php echo $misi; ?></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="alamat" class="form-label">Alamat</label>
                                    <input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo $alamat; ?>" required />
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" required />
                                </div>

                                <div class="mb-3">
                                    <label for="no_telepon" class="form-label">No Telepon</label>
                                    <input type="text" class="form-control" id="no_telepon" name="no_telepon" value="<?php echo $no_telepon; ?>" required />
                                </div>

                                <div class="mb-3">
                                    <label for="foto" class="form-label">Foto</label>
                                    <input type="file" class="form-control" id="foto" name="foto" />
                                    <!-- Show current photo -->
                                    <p>Foto Saat Ini: <img src="../../../storage/profil_sekolah/<?php echo $foto; ?>" width="100" /></p>
                                </div>

                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer section -->
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

    <!-- Bootstrap core JavaScript -->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript -->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages -->
    <script src="../js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../js/demo/datatables-demo.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>