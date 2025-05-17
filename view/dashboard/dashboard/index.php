<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['nama'])) {
    // If not logged in, redirect to login page
    header('Location: ../../../login.php');
    exit();
}

$nama = $_SESSION['nama'];
include '../../../koneksi.php'; // Include the database connection file

// Array of table names and labels for dynamic card generation
$cards = [
    ['table' => 'keunggulan', 'label' => 'Keunggulan', 'icon' => 'fa-trophy', 'color' => 'primary'],
    ['table' => 'guru', 'label' => 'Guru', 'icon' => 'fa-chalkboard-teacher', 'color' => 'success'],
    ['table' => 'fasilitas', 'label' => 'Fasilitas', 'icon' => 'fa-cogs', 'color' => 'info'],
    ['table' => 'galeri', 'label' => 'Galeri', 'icon' => 'fa-images', 'color' => 'warning'],
    ['table' => 'berita', 'label' => 'Berita', 'icon' => 'fa-newspaper', 'color' => 'danger'],
    ['table' => 'pendaftaran', 'label' => 'Pendaftaran', 'icon' => 'fa-pen', 'color' => 'secondary'],
    ['table' => 'users', 'label' => 'Users', 'icon' => 'fa-users', 'color' => 'primary']
];

// Fetch counts for each section dynamically
$counts = [];
foreach ($cards as $card) {
    $sql = "SELECT COUNT(*) AS jumlah FROM " . $card['table'];
    $result = $conn->query($sql);
    $counts[$card['table']] = $result->fetch_assoc()['jumlah'];
}

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

    <title>Dashboard</title>

    <!-- Custom fonts for this template -->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body id="page-top">

    <div id="wrapper">
        <?php include '../inc/sidebar.php' ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include '../inc/dashboard-header.php' ?>

                <div class="container-fluid">
                    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>

                    <div class="row mt-4"> <!-- Row for cards with a maximum of 4 per row -->
                        <?php
                        // Loop to generate cards dynamically
                        foreach ($cards as $index => $card) {
                            // Set a dynamic color class for the border
                            $colorClass = 'border-left-' . $card['color'];
                            // Set a dynamic icon class for the card
                            $iconClass = 'fas ' . $card['icon'] . ' fa-2x text-gray-300';
                            $count = $counts[$card['table']]; // Get the count from the fetched data
                            ?>
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card <?php echo $colorClass; ?> shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-<?php echo $card['color']; ?> text-uppercase mb-1">
                                                    <?php echo $card['label']; ?>
                                                </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    <?php echo $count; ?>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="<?php echo $iconClass; ?>"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
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

</body>

</html>
