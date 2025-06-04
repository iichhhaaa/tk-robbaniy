<?php
include 'koneksi.php';

$id = $_GET['id'];

// Prepare and execute query to get news data by ID
$sql_berita = "SELECT * FROM berita WHERE id = ? LIMIT 1";
$stmt = $conn->prepare($sql_berita);
$stmt->bind_param("i", $id); // 'i' means integer, bind $id to statement
$stmt->execute();
$result_berita = $stmt->get_result();

// Fetch news data
$row_berita = $result_berita->fetch_assoc();

// Prepare and execute query to get other news except current one
$sql_berita_lainnya = "SELECT * FROM berita WHERE id != ? ORDER BY created_at DESC LIMIT 5";
$stmt_lainnya = $conn->prepare($sql_berita_lainnya);
$stmt_lainnya->bind_param("i", $id);
$stmt_lainnya->execute();
$result_berita_lainnya = $stmt_lainnya->get_result();

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Berita</title>
  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
  <!-- Fonts & Custom CSS -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

  <!-- Navbar include -->
  <?php include 'inc/navbar.php' ?>

  <!-- Main content section -->
  <?php if ($row_berita) { ?>
    <div class="container my-5">
      <div class="row">
        <!-- Left column: news details -->
        <div class="col-md-8">
          <h2 class="fw-bold"><?php echo $row_berita['judul']; ?></h2>

          <img src="storage/berita/<?php echo $row_berita['foto']; ?>" alt="Berita" class="img-fluid rounded my-4" style="height: 450px; width: 100%; object-fit: cover;">
          <p class="text-muted"><?php echo $row_berita['created_at']; ?></p>
          <p class="profile-text text-justify">
            <?php echo $row_berita['content']; ?>
          </p>
        </div>

        <!-- Right column: other news list -->
        <div class="col-md-4">
          <h5 class="mb-4">Berita Lainnya</h5>

          <?php while ($row_lainnya = $result_berita_lainnya->fetch_assoc()) { ?>
            <a href="berita-detail.php?id=<?php echo $row_lainnya['id']; ?>" class="text-decoration-none text-black">

              <div class="mb-3 p-3 news-card">
                <p style="text-align: justify;" class="fw-bold"><?php echo $row_lainnya['judul']; ?></p>
                <small><?php echo $row_lainnya['created_at']; ?></small>
                <p style="text-align: justify;" class="mt-2"><?php echo substr($row_lainnya['content'], 0, 100); ?>...</p>
                <a href="berita-detail.php?id=<?php echo $row_lainnya['id']; ?>" class="text-white text-decoration-underline">Selengkapnya &gt;</a>
              </div>
            </a>
          <?php } ?>

        </div>
      </div>
    </div>
  <?php } else {
    // Message when no news is found with the given ID
    echo "Berita dengan ID tersebut tidak ditemukan.";
  } ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>