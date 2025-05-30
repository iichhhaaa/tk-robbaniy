<?php
include 'koneksi.php';

// Ambil data profil sekolah
$sql_profil = "SELECT * FROM profil_sekolah LIMIT 1";
$result_profil = $conn->query($sql_profil);
$profil = $result_profil->fetch_assoc();

// Ambil data guru
$sql_guru = "SELECT * FROM guru";
$result_guru = $conn->query($sql_guru);

// Ambil data fasilitas
$sql_fasilitas = "SELECT * FROM fasilitas";
$result_fasilitas = $conn->query($sql_fasilitas);

$conn->close();
?>


<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Profil</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="assets/css/style.css">

</head>

<body class="d-flex flex-column min-vh-100">
  <!-- Navbar -->
  <?php include 'inc/navbar.php' ?>

  <main class="container my-5">
    <section class="row align-items-center">
      <div class="col-md-7">
        <h2 class="section-title">Profil</h2>
        <p class="profile-text text-justify">
          <?php echo isset($profil["deskripsi"]) ? $profil["deskripsi"] : ''; ?>
        </p>
      </div>

      <div class="col-md-5 d-flex justify-content-center">
        <div class="d-flex gap-3 mt-4 mt-md-0">
          <!-- Kartun -->
          <img src="storage/profil_sekolah/<?php echo isset($profil["foto"]) ? $profil["foto"] : ''; ?>" alt="" style="height: 290px;" />
        </div>
      </div>
    </section>

    <section class="mt-5">
      <div class="vision-mission mb-4">
        <h5 class="fw-bold text-success">VISI</h5>
        <p class="mt-3"><?php echo isset($profil["visi"]) ? $profil["visi"] : ''; ?></p>
      </div>

      <!-- Tampilkan div MISI dengan latar belakang meskipun data kosong -->
      <div class="vision-mission mb-4">
        <h5 class="fw-bold text-success">MISI</h5>
        <ol class="mt-3">
          <?php
          if (isset($profil["misi"]) && !empty($profil["misi"])) {
            // Membagi data misi berdasarkan baris baru
            $misi_array = explode("\n", $profil["misi"]);
            foreach ($misi_array as $item) {
              echo "<li>" . trim($item) . "</li>"; // Menampilkan tiap misi
            }
          } else {
            // Jika tidak ada data misi, tampilkan pesan kosong
            echo "";
          }
          ?>
        </ol>
      </div>
    </section>


    <section class="mt-5">
      <h3 class="section-title text-center text-success mb-5">GURU</h3>
      <div class="row justify-content-center text-center">
        <?php while ($row = $result_guru->fetch_assoc()) { ?>
          <div class="col-md-3 d-flex flex-column align-items-center mb-4"> <!-- Menambahkan margin bawah pada setiap kolom untuk jarak antar baris -->
            <img src="storage/guru/<?php echo $row['foto']; ?>" width="auto" height="200" class="mb-2"> <!-- Jarak antara gambar dan nama -->
            <p class="mb-0 mt-2"><?php echo $row['nama']; ?></p> <!-- Jarak antara nama dan jabatan -->
            <small class="mt-1"><?php echo $row['jabatan']; ?></small> <!-- Memberikan jarak antara nama dan jabatan -->
          </div>
        <?php } ?>
      </div>

    </section>

    <section class="mt-5">
      <h3 class="section-title text-center text-success mb-5">FASILITAS</h3>
      <div class="row g-3">
        <?php
        // Pastikan koneksi sudah dibuka dan query berhasil dijalankan
        while ($row = $result_fasilitas->fetch_assoc()) { ?>
          <div class="col-12 col-sm-6 col-md-4">
            <!-- Menampilkan gambar dengan rasio 3:2 menggunakan inline CSS -->
            <img src="storage/fasilitas/<?php echo $row['foto']; ?>" alt="Fasilitas" class="img-fluid"
              style="width: 100%; height: auto; aspect-ratio: 3 / 2; object-fit: cover;">
            <!-- Menampilkan caption -->
            <p class="caption mt-4"><?php echo $row['nama']; ?></p>
          </div>
        <?php } ?>
      </div>
    </section>


  </main>

  <footer class="text-center py-4 text-white bg-dark mt-0">
    © 2025 TK Islam Robbani. Mendidik dengan Akhlak Qurani Sejak Dini.
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
