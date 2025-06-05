<?php
include 'koneksi.php';

// Query to select all records from the 'galeri' table
$sql = "SELECT * FROM galeri";
$result = $conn->query($sql);

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Galeri</title>
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

  <!-- Main Content Section -->
  <section class="container mt-5 d-flex align-items-center justify-content-between flex-column flex-md-row py-5 <?php echo $row ? '' : 'min-vh-100'; ?>">
    <div class="row g-3">
      <?php
      // Loop through each gallery record and display image and title
      while ($row = $result->fetch_assoc()) { ?>
        <div class="col-12 col-md-4">
          <!-- Display gallery image -->
          <img src="storage/galeri/<?php echo $row['foto']; ?>" alt="Gallery Image" class="img-fluid">
          <!-- Display image caption/title -->
          <p class="caption mt-4"><?php echo $row['judul']; ?></p>
        </div>
      <?php } ?>
    </div>
  </section>

  <!-- Footer -->
  <footer class="text-center py-4 text-white bg-dark mt-5">
    © 2025 TK Islam Robbani. Mendidik dengan Akhlak Qurani Sejak Dini.
  </footer>

  <!-- Bootstrap JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>