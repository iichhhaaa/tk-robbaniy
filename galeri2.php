<?php
include 'koneksi.php';
// Menjalankan query untuk mengambil satu data dari tabel profil_sekolah
$sql = "SELECT * FROM galeri";
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
    <div class="row g-3">
        <?php 
        if(!$result || $result->num_rows == 0) { 
            echo "<p>Tidak ada data galeri</p>";
        } else {
            while ($row = $result->fetch_assoc()) { ?>
                <div class="col-12 col-md-4">
                    <!-- Menampilkan gambar -->
                    <img src="storage/galeri/<?php echo $row['foto']; ?>" alt="Gallery Image" class="img-fluid">
                    <p class="caption mt-4"><?php echo $row['judul']; ?></p>
                </div>
            <?php }
        } ?>
    </div>
  </section>

  <!-- Footer -->
  <footer class="text-center py-4 text-white bg-dark  mt-0">
    © 2025 TK Islam Robbaniy. All rights reserved.
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>