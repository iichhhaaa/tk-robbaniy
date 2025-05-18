<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Islam Robbaniy</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <?php if ($_SESSION['role'] === 'admin') { ?>
        <!-- Nav Item - Dashboard -->
        <li class="nav-item">
            <a class="nav-link" href="../dashboard/index.php">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Konten
        </div>

        <!-- Nav Item - Keunggulan -->
        <li class="nav-item">
            <a class="nav-link" href="../keunggulan/index.php">
                <i class="fas fa-fw fa-trophy"></i> <!-- Icon for Keunggulan -->
                <span>Keunggulan</span>
            </a>
        </li>

        <!-- Nav Item - Profil Sekolah -->
        <li class="nav-item">
            <a class="nav-link" href="../profil_sekolah/index.php">
                <i class="fas fa-fw fa-school"></i> <!-- Icon for Profil Sekolah -->
                <span>Profil</span>
            </a>
        </li>

        <!-- Nav Item - Guru -->
        <li class="nav-item">
            <a class="nav-link" href="../guru/index.php">
                <i class="fas fa-fw fa-chalkboard-teacher"></i> <!-- Icon for Guru -->
                <span>Guru</span>
            </a>
        </li>

        <!-- Nav Item - Fasilitas -->
        <li class="nav-item">
            <a class="nav-link" href="../fasilitas/index.php">
                <i class="fas fa-fw fa-building"></i> <!-- Icon for Fasilitas -->
                <span>Fasilitas</span>
            </a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Dokumentasi
        </div>

        <!-- Nav Item - Galeri -->
        <li class="nav-item">
            <a class="nav-link" href="../galeri/index.php">
                <i class="fas fa-fw fa-images"></i> <!-- Icon for Galeri -->
                <span>Galeri</span>
            </a>
        </li>

        <!-- Nav Item - Berita -->
        <li class="nav-item">
            <a class="nav-link" href="../berita/index.php">
                <i class="fas fa-fw fa-newspaper"></i> <!-- Icon for Berita -->
                <span>Berita</span>
            </a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Pendaftaran
        </div>

        <!-- Nav Item - Pendaftaran -->
        <li class="nav-item">
            <a class="nav-link" href="../pendaftaran/index.php">
                <i class="fas fa-fw fa-clipboard-list"></i> <!-- Icon for Pendaftaran -->
                <span>Pendaftaran</span>
            </a>
        </li>

        <!-- Nav Item - Info Pendaftaran -->
        <li class="nav-item">
            <a class="nav-link" href="../info_pendaftaran/index.php">
                <i class="fas fa-fw fa-info-circle"></i> <!-- Icon for Info Pendaftaran -->
                <span>Info Pendaftaran</span>
            </a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Users -->
        <li class="nav-item">
            <a class="nav-link" href="../users/index.php">
                <i class="fas fa-fw fa-users"></i> <!-- Icon for Users -->
                <span>Pengguna</span>
            </a>
        </li>


        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Keluar -->
        <li class="nav-item">
            <a class="nav-link" href="../inc/logout.php">
                <i class="fas fa-fw fa-sign-out-alt"></i> <!-- Icon for Logout -->
                <span>Keluar</span>
            </a>
        </li>

    <?php } else if ($_SESSION['role'] === 'capen') { ?>
        <!-- Divider -->
        <hr class="sidebar-divider my-0">
        <!-- Nav Item - Dashboard -->
        <li class="nav-item">
            <a class="nav-link" href="../dashboard-capen/dashboard-user.php">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">
        <!-- Nav Item - pendaftaran -->
        <li class="nav-item">
            <a class="nav-link" href="../dashboard-capen/index.php">
                <i class="fas fa-fw fa-users"></i> <!-- Icon for Users -->
                <span>Pendaftaran</span>
            </a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">
        <!-- Nav Item - status -->
        <li class="nav-item">
            <a class="nav-link" href="../dashboard-capen/status.php">
                <i class="fas fa-fw fa-users"></i> <!-- Icon for Users -->
                <span>Status</span>
            </a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Keluar -->
        <li class="nav-item">
            <a class="nav-link" href="../inc/logout.php">
                <i class="fas fa-fw fa-sign-out-alt"></i> <!-- Icon for Logout -->
                <span>Keluar</span>
            </a>
        </li>

    <?php } ?>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->


<!-- jQuery and Bootstrap JS for Toggler
<script src="../vendor/jquery/jquery.min.js"></script>
<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script>
    // Toggle Sidebar for responsive view
    $('#sidebarToggle').on('click', function () {
        $('#accordionSidebar').toggleClass('toggled');
    }); -->
</script>