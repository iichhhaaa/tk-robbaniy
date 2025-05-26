<?php
include 'koneksi.php';
// Menjalankan query untuk mengambil satu data dari tabel profil_sekolah
$sql = "SELECT * FROM profil_sekolah LIMIT 1";
$result = $conn->query($sql);

$row = $result->fetch_assoc();

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Kontak</title>
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
    <div class="row text-center mb-4">
      <div class="col-md-4 mb-4">
        <div class="contact-box">
          <i class="bi bi-envelope" style="font-size: 32px; color: #2e7d32;"></i>
          <h6>Alamat Email</h6>
          <?php echo isset($row["email"]) ? $row["email"] : ''; ?>
        </div>
      </div>
      <div class="col-md-4 mb-4">
        <div class="contact-box">
          <i class="bi bi-telephone" style="font-size: 32px; color: #2e7d32;"></i>
          <h6>Telepon</h6>
          <?php echo isset($row["no_telepon"]) ? $row["no_telepon"] : ''; ?>
        </div>
      </div>
      <div class="col-md-4 mb-4">
        <div class="contact-box">
          <i class="bi bi-geo-alt" style="font-size: 32px; color: #2e7d32;"></i>
          <h6>Alamat</h6>
          <?php echo isset($row["alamat"]) ? $row["alamat"] : ''; ?>
        </div>
      </div>
    </div>

    <!-- Google Map -->
    <div class="row justify-content-center py-3 px-0">
      <div class="col-12">
        <div class="map-container mb-0">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.1510182494044!2d106.83162057453316!3d-6.3744967623535915!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69ec0ed3efeaf5%3A0x9b084199392bfb55!2sTK%20Islam%20Robbaniy%20Mawar!5e0!3m2!1sid!2sid!4v1746343294344!5m2!1sid!2sid" width="100%" height="800" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="text-center py-4 text-white bg-dark  mt-0">
    © 2025 TK Islam Robbani. Mendidik dengan Akhlak Qurani Sejak Dini.
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>