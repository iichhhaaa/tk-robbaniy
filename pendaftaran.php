<?php
include 'koneksi.php';

// Query to get all data from info_pendaftaran table
$sql_info = "SELECT * FROM info_pendaftaran";
$result_info = $conn->query($sql_info);
$info = $result_info->fetch_assoc();

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Info Pendaftaran</title>
  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
  <!-- Fonts & Custom CSS -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="d-flex flex-column min-vh-100">

  <!-- Navbar -->
  <?php include 'inc/navbar.php' ?>

  <!-- Registration Section -->
  <section class="container my-5 py-5 flex-grow-1">
    <div class="row">
      <!-- Registration Requirements -->
      <div class="col-12 col-md-6">
        <div class="card p-3 mb-4">
          <h4 class="card-title">Syarat Pendaftaran</h4>
          <ul class="list-group">
            <?php 
            if (isset($info["syarat_pendaftaran"]) && !empty($info["syarat_pendaftaran"])) {
              // Get the registration requirements data from database
              // Split the data into an array by new line
              $syarat_array = explode("\n", $info["syarat_pendaftaran"]);
              // Loop through each requirement and display it as a list item
              foreach($syarat_array as $item) {
                echo "<li class='list-group-item'>" . trim($item) . "</li>";
              } 
            } else {
              // Show this message if there is no registration requirements info
              echo "<li class='list-group-item'>Tidak ada informasi syarat pendaftaran.</li>";
            }
            ?>
          </ul>
        </div>
      </div>

      <!-- PPDB Fees -->
      <div class="col-12 col-md-6">
        <div class="card p-3 mb-4">
          <h5 class="card-title">Biaya PPDB</h5>
          <ul class="list-group">
            <?php 
            if (isset($info["biaya_ppdb"]) && !empty($info["biaya_ppdb"])) {
              // Get the PPDB fees data from database
              // Split the data into an array by new line
              $biaya_array = explode("\n", $info["biaya_ppdb"]);
              // Loop through each fee item and display it as a list item
              foreach($biaya_array as $item) {
                echo "<li class='list-group-item'>" . trim($item) . "</li>";
              } 
            } else {
              // Show this message if there is no PPDB fees info
              echo "<li class='list-group-item'>Tidak ada informasi biaya PPDB.</li>";
            }
            ?>
          </ul>
        </div>
      </div>
    </div>

    <!-- Register Now Button -->
    <div class="col-12">
      <a href="login.php" class="btn btn-warning w-100 text-white">Daftar Sekarang</a>
    </div>
  </section>

  <!-- Footer -->
  <footer class="text-center py-4 bg-dark text-white mt-auto">
    © 2025 TK Islam Robbani. Mendidik dengan Akhlak Qurani Sejak Dini.
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>