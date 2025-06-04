<?php
include 'koneksi.php';
// Execute query to fetch all news from the berita table
$sql_berita = "SELECT * FROM berita";
$result_berita = $conn->query($sql_berita);

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Berita</title>
  <!-- Bootstrap CSS and Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
  <!-- Google Fonts and Custom CSS -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="d-flex flex-column min-vh-100">

  <!-- Include navbar -->
  <?php include 'inc/navbar.php' ?>

  <div class="container my-5 py-5 flex-grow-1">
    <!-- News Section -->
    <section class="row g-4">
      <?php
      // Loop through each news item fetched from the database
      while ($row_berita = $result_berita->fetch_assoc()) { ?>
        <div class="col-12 col-sm-12 col-md-4">
          <div class="card bg-white border-0 mb-4">
            <!-- Make the entire card clickable linking to news detail -->
            <a href="berita-detail.php?id=<?php echo $row_berita['id']; ?>" class="text-decoration-none">
              <!-- Responsive image with fixed size and object-fit to cover -->
              <img src="storage/berita/<?php echo $row_berita["foto"]; ?>" alt="Berita" class="img-fluid d-block mx-auto" style="width: 380px; height: 250px; object-fit: cover;">
              <div class="card-body p-3">
                <h5 class="card-title text-success"><?php echo $row_berita['judul']; ?></h5>
                <p class="text-muted"><?php echo $row_berita['created_at']; ?></p>
                <!-- Show a preview snippet of content limited to 300 characters -->
                <p class="card-text text-success" style="text-align: justify;">
                  <?php echo substr($row_berita['content'], 0, 300); ?>...
                </p>
              </div>
            </a>
          </div>
        </div>
      <?php } ?>
    </section>
  </div>

  <!-- Footer -->
  <footer class="text-center py-4 text-white bg-dark mt-auto">
    © 2025 TK Islam Robbani. Mendidik dengan Akhlak Qurani Sejak Dini.
  </footer>

  <!-- Bootstrap JS bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>