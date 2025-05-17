<?php
include 'koneksi.php';
// Menjalankan query untuk mengambil satu data dari tabel profil_sekolah
$sql = "SELECT * FROM info_pendaftaran";
$result = $conn->query($sql);

$row = $result->fetch_assoc();

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Beranda</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/style.css">

</head>
<body class="d-flex flex-column min-vh-100">

  <!-- Navbar -->
  <?php include 'inc/navbar.php' ?>

  <!-- Kontak Section -->
  <section class="container my-5 py-5">
    <div class="row">
      <!-- Syarat Pendaftaran -->
      <div class="col-12 col-md-6">
        <div class="card p-3 mb-4">
          <h4 class="card-title">Syarat Pendaftaran</h4>
          <ul class="list-group">
            <li class="list-group-item">Mengisi Formulir Pendaftaran</li>
            <li class="list-group-item">Fotokopi Kartu Keluarga (KK) dan KTP Orang Tua/Wali</li>
            <li class="list-group-item">Fotokopi Akta Kelahiran</li>
          </ul>
        </div>
      </div>

      <!-- Biaya PPDB -->
      <div class="col-12 col-md-6">
        <div class="card p-3 mb-4">
          <h4 class="card-title">Biaya PPDB</h4>
          <ul class="list-group">
            <li class="list-group-item">Dana Pengembangan Pendidikan: Rp 500.000</li>
            <li class="list-group-item">Dana Sarana dan Prasarana: Rp 275.000</li>
            <li class="list-group-item">Seragam 3 Setel: Rp 500.000</li>
            <li class="list-group-item">SPP Bulan Juli 2025: Rp 150.000</li>
          </ul>
        </div>
      </div>
    </div>

    <!-- Daftar Sekarang Button -->
    <a href="pendaftaran_form.php" class="btn btn-warning w-100">Daftar Sekarang</a>
  </section>

  <!-- Footer -->
  <footer class="text-center py-4 bg-dark text-white">
    © 2025 TK Islam Robbani. All rights reserved.
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
