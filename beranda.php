<?php
include 'koneksi.php';
// Menjalankan query untuk mengambil satu data dari tabel profil_sekolah
$sql_keunggulan = "SELECT * FROM keunggulan";
$result_keunggulan = $conn->query($sql_keunggulan);

$sql_profil = "SELECT * FROM profil_sekolah LIMIT 1";
$result_profil = $conn->query($sql_profil);
$row_profil = $result_profil->fetch_assoc();

$sql_galeri = "SELECT * FROM galeri ORDER BY id DESC LIMIT 4";
$result_galeri = $conn->query($sql_galeri);
$row_galeri = $result_galeri->fetch_assoc();


// $row = $result->fetch_assoc();
// // Mengecek apakah ada data yang ditemukan
// if ($result->num_rows > 0) {
//   // Mengambil data pertama (hanya satu record)
//   $row = $result->fetch_assoc();
//   echo "<h3>" . $row["nama_sekolah"] . "</h3>";
//   echo "<p>Alamat: " . $row["alamat"] . "</p>";
//   echo "<p>No Telepon: " . $row["no_telepon"] . "</p>";
//   echo "<p>Email: " . $row["email"] . "</p>";
// } else {
//   echo "Tidak ada data yang ditemukan";
// }

// Menutup koneksi
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

  <!-- Header / Welcome -->
  <section class="container my-0 min-vh-100 d-flex align-items-center justify-content-between flex-column flex-md-row py-5">
    <div class="text-center text-md-start">
      <h1>Selamat Datang di <br /><span class="text-success">TK Islam Robbaniy</span></h1>
      <p class="fs-5">Tempat terbaik untuk membentuk karakter islami anak sejak dini</p>

      <a href="login.php">
        <button class="btn btn-daftar">Daftar Sekarang</button>
      </a>
    </div>
    <div class="d-flex gap-3 mt-4 mt-md-0 justify-content-center">
      <!-- Kartun -->
      <img src="assets/anak.jpg" alt="Anak" class="img-fluid" style="max-height: 350px;" />
    </div>
  </section>


  <!-- Keunggulan -->
  <section class="bg-light py-5">
    <div class="container py-4">
      <h2 class="text-center text-success mb-5">Keunggulan</h2>
      <!-- Baris pertama: maksimal 3 item per baris -->
      <div class="row g-4 justify-content-center mt-3">
        <?php
        // Pastikan koneksi sudah dibuka dan query berhasil dijalankan
        $counter = 0;  // Variabel untuk menghitung jumlah kolom per baris
        while ($row = $result_keunggulan->fetch_assoc()) {
          if ($counter == 3) { // Jika sudah ada 3 kolom, buat baris baru
            $counter = 0;
            echo '</div><div class="row g-4 justify-content-center mt-3">';  // Membuat baris baru
          }
        ?>
          <div class="col-12 col-sm-6 col-md-4 col-lg-3 keunggulan-item text-center">
            <!-- Mengganti <i> dengan <img> untuk icon -->
            <img src="storage/keunggulan/<?php echo $row["foto"]; ?>" alt="Keunggulan Icon" class="keunggulan-icon" width="100" height="100">
            <h5><?php echo $row['judul']; ?></h5>
            <p><?php echo $row['deskripsi']; ?></p> <!-- Menampilkan deskripsi keunggulan -->
          </div>
        <?php
          $counter++; // Meningkatkan penghitung setiap kali kolom ditambahkan
        }
        ?>
      </div>
    </div>
  </section>
  </div>
  </div>
  </section>

  <!-- Mini Galeri -->
  <section class="container my-5 py-5">
    <h2 class="text-center text-success mb-5">Mini Galeri</h2>
    <div class="row g-3 justify-content-center mt-3">
      <?php
      while ($row_galeri = $result_galeri->fetch_assoc()) { ?>
        <div class="col-12 col-md-4">
          <!-- Menampilkan gambar dengan sudut bulat -->
          <img src="storage/galeri/<?php echo $row_galeri['foto']; ?>" alt="Gallery Image" class="img-fluid rounded">
          <p class="caption mt-4"><?php echo $row_galeri['judul']; ?></p>
        </div>
      <?php } ?>
    </div>
  </section>

  <!-- Kontak dan Peta -->
  <section class="container my-5 py-3">
    <div class="row align-items-center">
      <div class="col-md-6 mb-4 mb-md-0">
        <h3 class="text-success">TK Islam Robbaniy</h3>
        <!-- Menampilkan nomor telepon, email, dan alamat dalam paragraf terpisah dengan jarak lebih dekat -->
        <p style="margin-bottom: 5px;"><?php echo isset($row_profil["email"]) ? $row_profil["email"] : ''; ?></p>
        <p style="margin-bottom: 5px;"><?php echo isset($row_profil["no_telepon"]) ? $row_profil["no_telepon"] : ''; ?>
        <p style="margin-bottom: 0;"><?php echo isset($row_profil["alamat"]) ? $row_profil["alamat"] : ''; ?>
      </div>
      <div class="col-md-6 map-container" style="height: 300px; overflow: hidden;">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.1510182494044!2d106.83162057453316!3d-6.3744967623535915!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69ec0ed3efeaf5%3A0x9b084199392bfb55!2sTK%20Islam%20Robbaniy%20Mawar!5e0!3m2!1sid!2sid!4v1746343294344!5m2!1sid!2sid" width="100%" height="100%" style="border:0; width: 100%; height: 100%; object-fit: cover;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
      </div>
    </div>
  </section>

  <footer class="text-center py-4 text-white bg-dark mt-0">
    © 2025 TK Islam Robbani. Mendidik dengan Akhlak Qurani Sejak Dini.
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>