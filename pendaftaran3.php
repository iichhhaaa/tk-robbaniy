<?php
include 'koneksi.php';

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
  <title>Pendaftaran</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  
  <!-- Google Fonts: Poppins -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="d-flex flex-column min-vh-100">

  <!-- Navbar -->
  <?php include 'inc/navbar.php' ?>

  <!-- Section Pendaftaran -->
  <section class="container my-5 py-5 mt-5 flex-grow-1">
    <div class="row justify-content-center">
      
      <!-- Syarat Pendaftaran -->
      <div class="col-lg-10 section-box mb-4 d-flex flex-column flex-md-row mt-0">
        <div class="col-md-4 section-title mb-3 mb-md-0" style="margin-top: -15px;">
          <h5>Syarat<br>Pendaftaran</h5>
        </div>
        <div class="col-md-8">
            <?php 
            if (isset($info["syarat_pendaftaran"]) && !empty($info["syarat_pendaftaran"])) {
            // Mengambil data syarat_pendaftaran dari database
            $syarat_array = explode("\n", $info["syarat_pendaftaran"]); // Memecah data menjadi array berdasarkan baris baru
            foreach($syarat_array as $item) {
                echo "<li>" . trim($item) . "</li>"; // Menampilkan setiap item sebagai list
            } 
          } else {
            // Jika tidak ada data misi, tampilkan pesan kosong
            echo "";
          }
            ?>
        </ol>
        </div>
      </div>

      <!-- Biaya PPDB -->
      <div class="col-lg-10 section-box mb-4 d-flex flex-column flex-md-row mt-0">
          <div class="col-md-4 section-title mb-3 mb-md-0" style="margin-top: -15px;">
              <h5>Biaya<br>PPDB</h5>
          </div>
          <div class="col-md-8">
                  <?php 
                  if (isset($info["biaya_ppdb"]) && !empty($info["biaya_ppdb"])) {
                  // Mengambil data biaya_ppdb dari database
                  $biaya_array = explode("\n", $info["biaya_ppdb"]); // Memecah data menjadi array berdasarkan baris baru
                  foreach($biaya_array as $item) {
                      echo "<li>" . trim($item) . "</li>"; // Menampilkan setiap item sebagai list
                  } } else {
            // Jika tidak ada data misi, tampilkan pesan kosong
            echo "";
          }
                  ?>
              </ul>
          </div>
      </div>

      <!-- Tombol Daftar -->
      <div class="col-lg-10 text-center mt-4">
        <a href="login.php" class="btn btn-warning px-5 py-2 fw-semibold rounded-pill">Daftar Sekarang</a>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="text-center py-4 text-white bg-dark mt-0">
    © 2025 TK Islam Robbaniy. All rights reserved.
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  
</body>
</html> 