<?php
include 'koneksi.php';

// Ambil data berita
$sql_berita = "SELECT * FROM berita";
$result_berita = $conn->query($sql_berita);

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Berita</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="assets/css/style.css">

</head>

<body class="d-flex flex-column min-vh-100">
  <!-- Navbar -->
  <?php include 'inc/navbar.php' ?>

  <section class="container my-0 min-vh-100 d-flex align-items-center justify-content-between flex-column flex-md-row py-5">
        <div class="row g-4">
          <?php
          // Loop through each berita
          while ($row_berita = $result_berita->fetch_assoc()) { ?>
            <div class="col-12 col-sm-12 col-md-4">
              <div class="card bg-white border-0 mb-4">
                <!-- Wrap the entire card in an <a> tag to make it clickable -->
                <a href="berita-detail.php?id=<?php echo $row_berita['id']; ?>" class="text-decoration-none">
                  <!-- Set image width to 380px, auto height, and center the image using Bootstrap -->
<img src="storage/berita/<?php echo $row_berita['foto']; ?>" alt="Berita" class="img-fluid d-block mx-auto" style="width: 380px; height: 250px; object-fit: cover;">
                  <div class="card-body p-3">
                    <h5 class="card-title text-success"><?php echo $row_berita['judul']; ?></h5>
                    <p class="text-muted"><?php echo $row_berita['created_at']; ?></p>
                    <!-- Limit content length to a specific number of characters, e.g., 300 characters -->
                    <p class="card-text text-success" style="text-align: justify;">
                      <?php echo substr($row_berita['content'], 0, 300); ?>...
                    </p>
                  </div>
                </a>
              </div>

            </div>

          <?php } ?>
        </div>

      </section>

  <footer class="text-center py-4 text-white bg-dark mt-0">
    © 2025 TK Islam Robbaniy. All rights reserved.
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>