<!-- Navbar -->
<nav class="navbar navbar-expand-lg py-3">
  <div class="container">
    <!-- Logo on the left side of the navbar -->
    <a class="navbar-brand fw-bold d-flex align-items-center" href="#">
      <img src="assets/logo.png" alt="Logo TK Islam Robbaniy" style="height:40px; margin-right:10px;" />
      Tk Islam Robbaniy
    </a>

    <!-- Toggle button for mobile navigation -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon" style="color:#fff;"></span>
    </button>
    
    <!-- Navigation menu items -->
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav align-items-center">
        <!-- Main navigation links -->
        <li class="nav-item"><a class="nav-link" href="beranda.php">Beranda</a></li>
        <li class="nav-item"><a class="nav-link" href="profil.php">Profil</a></li>
        <li class="nav-item"><a class="nav-link" href="galeri.php">Galeri</a></li>
        <li class="nav-item"><a class="nav-link" href="berita.php">Berita</a></li>
        <li class="nav-item"><a class="nav-link" href="pendaftaran.php">Pendaftaran</a></li>
        <li class="nav-item"><a class="nav-link" href="kontak.php">Kontak</a></li>
        
        <!-- Show login button or user name depending on session -->
        <li class="nav-item">
          <?php 
            session_start(); 
            if (isset($_SESSION['nama']) && isset($_SESSION['role'])): 
              $dashboardPath = '';
              if ($_SESSION['role'] === 'admin') {
                $dashboardPath = 'view/dashboard/dashboard/index.php';
              } elseif ($_SESSION['role'] === 'capen') {
                $dashboardPath = 'view/dashboard/dashboard-capen/index.php';
              }
          ?>
            <a class="nav-link" href="<?php echo $dashboardPath; ?>">
              <button class="btn btn-masuk"><?php echo $_SESSION['nama']; ?></button>
            </a>
          <?php else: ?>
            <a href="login.php">
              <button class="btn btn-masuk">Masuk</button>
            </a>
          <?php endif; ?>
        </li>
      </ul>
    </div>
  </div>
</nav>
