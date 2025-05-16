<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['nama'])) {
    // If not logged in, redirect to login page
    header('Location: login.php');
    exit();
}

// Get the user's name from the session
$nama = $_SESSION['nama'];
include '../../../koneksi.php';
// Menjalankan query untuk mengambil satu data dari tabel profil_sekolah
$sql = "SELECT * FROM pendaftaran";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$setting = "SELECT value FROM settings WHERE key_name = 'pendaftaran_status'";
$result_setting = $conn->query($setting);
$row_setting = $result_setting->fetch_assoc();
$status = $row_setting['value'];

$conn->close();
?>
<?php

// Cek apakah pengguna sudah login dan memiliki role 'admin'
if (!isset($_SESSION['nama']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

include '../../../koneksi.php';  // Koneksi ke database

// Ambil ID pendaftaran dari parameter URL (GET)
$id_pendaftaran = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id_pendaftaran <= 0) {
    die('ID pendaftaran tidak valid.');
}

// Query untuk mendapatkan data pendaftaran beserta data murid, ayah, ibu
$sql = "SELECT 
            p.id AS id, p.kode_pendaftaran, p.berkas,
            m.nama AS nama_murid, m.nik AS nik_murid, m.tempat_lahir AS tempat_lahir_murid, m.tanggal_lahir AS tanggal_lahir_murid,
            m.jenis_kelamin AS jenis_kelamin_murid, m.alamat AS alamat_murid, m.telepon AS telepon_murid, m.riwayat_kesehatan AS riwayat_kesehatan_murid,
            m.anak_ke AS anak_ke_murid,
            i.nama AS nama_ibu, i.tempat_lahir AS tempat_lahir_ibu, i.tanggal_lahir AS tanggal_lahir_ibu, i.nik AS nik_ibu, 
            i.agama AS agama_ibu, i.pekerjaan AS pekerjaan_ibu, i.penghasilan AS penghasilan_ibu, i.alamat AS alamat_ibu,
            i.telepon AS telepon_ibu, a.nama AS nama_ayah, a.tempat_lahir AS tempat_lahir_ayah, a.tanggal_lahir AS tanggal_lahir_ayah,
            a.nik AS nik_ayah, a.agama AS agama_ayah, a.pekerjaan AS pekerjaan_ayah, a.penghasilan AS penghasilan_ayah, 
            a.alamat AS alamat_ayah, a.telepon AS telepon_ayah
        FROM pendaftaran p
        INNER JOIN murid m ON p.murid_id = m.id
        INNER JOIN ayah a ON p.ayah_id = a.id
        INNER JOIN ibu i ON p.ibu_id = i.id
        WHERE p.id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_pendaftaran); // Binding parameter ID
$stmt->execute();
$result = $stmt->get_result();

// Jika data ditemukan
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "Data tidak ditemukan.";
    exit();
}

// Tutup koneksi
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detail Pendaftaran Murid</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body id="page-top">

    <div id="wrapper">
        <?php include '../inc/sidebar.php' ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include '../inc/dashboard-header.php' ?>

                <div class="container-fluid">
                    <h1 class="h3 mb-4 text-gray-800">Detail Pendaftaran Murid</h1>

                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <h5 class="mt-4">Data Pendaftaran</h5>
                            <table class="table table-bordered" style="table-layout: fixed;">
                                <tr>
                                    <th>Kode Pendaftaran</th>
                                    <td><?php echo $row['kode_pendaftaran']; ?></td>
                                </tr>
                                <tr>
                                    <th>Nama Murid</th>
                                    <td><?php echo $row['nama_murid']; ?></td>
                                </tr>
                                <tr>
                                    <th>NIK</th>
                                    <td><?php echo $row['nik_murid']; ?></td>
                                </tr>
                                <tr>
                                    <th>Tempat, Tanggal Lahir</th>
                                    <td><?php echo $row['tempat_lahir_murid'] . ', ' . $row['tanggal_lahir_murid']; ?></td>
                                </tr>
                                <tr>
                                    <th>Jenis Kelamin</th>
                                    <td><?php echo $row['jenis_kelamin_murid']; ?></td>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <td><?php echo $row['alamat_murid']; ?></td>
                                </tr>
                                <tr>
                                    <th>Telepon</th>
                                    <td><?php echo $row['telepon_murid']; ?></td>
                                </tr>
                                <tr>
                                    <th>Riwayat Kesehatan</th>
                                    <td><?php echo $row['riwayat_kesehatan_murid']; ?></td>
                                </tr>
                                <tr>
                                    <th>Anak Ke</th>
                                    <td><?php echo $row['anak_ke_murid']; ?></td>
                                </tr>
                            </table>

                            <h5 class="mt-4">Data Orang Tua</h5>
                            <table class="table table-bordered" style="table-layout: fixed;">
                                <tr>
                                    <th>Nama Ibu</th>
                                    <td><?php echo $row['nama_ibu']; ?></td>
                                </tr>
                                <tr>
                                    <th>Tempat Lahir Ibu</th>
                                    <td><?php echo $row['tempat_lahir_ibu']; ?></td>
                                </tr>
                                <tr>
                                    <th>Tanggal Lahir Ibu</th>
                                    <td><?php echo $row['tanggal_lahir_ibu']; ?></td>
                                </tr>
                                <tr>
                                    <th>NIK Ibu</th>
                                    <td><?php echo $row['nik_ibu']; ?></td>
                                </tr>
                                <tr>
                                    <th>Agama Ibu</th>
                                    <td><?php echo $row['agama_ibu']; ?></td>
                                </tr>
                                <tr>
                                    <th>Pekerjaan Ibu</th>
                                    <td><?php echo $row['pekerjaan_ibu']; ?></td>
                                </tr>
                                <tr>
                                    <th>Penghasilan Ibu</th>
                                    <td><?php echo $row['penghasilan_ibu']; ?></td>
                                </tr>
                                <tr>
                                    <th>Alamat Ibu</th>
                                    <td><?php echo $row['alamat_ibu']; ?></td>
                                </tr>
                                <tr>
                                    <th>Telepon Ibu</th>
                                    <td><?php echo $row['telepon_ibu']; ?></td>
                                </tr>
                            </table>

                            <h5 class="mt-4">Data Ayah</h5>
                            <table class="table table-bordered" style="table-layout: fixed;">
                                <tr>
                                    <th>Nama Ayah</th>
                                    <td><?php echo $row['nama_ayah']; ?></td>
                                </tr>
                                <tr>
                                    <th>Tempat Lahir Ayah</th>
                                    <td><?php echo $row['tempat_lahir_ayah']; ?></td>
                                </tr>
                                <tr>
                                    <th>Tanggal Lahir Ayah</th>
                                    <td><?php echo $row['tanggal_lahir_ayah']; ?></td>
                                </tr>
                                <tr>
                                    <th>NIK Ayah</th>
                                    <td><?php echo $row['nik_ayah']; ?></td>
                                </tr>
                                <tr>
                                    <th>Agama Ayah</th>
                                    <td><?php echo $row['agama_ayah']; ?></td>
                                </tr>
                                <tr>
                                    <th>Pekerjaan Ayah</th>
                                    <td><?php echo $row['pekerjaan_ayah']; ?></td>
                                </tr>
                                <tr>
                                    <th>Penghasilan Ayah</th>
                                    <td><?php echo $row['penghasilan_ayah']; ?></td>
                                </tr>
                                <tr>
                                    <th>Alamat Ayah</th>
                                    <td><?php echo $row['alamat_ayah']; ?></td>
                                </tr>
                                <tr>
                                    <th>Telepon Ayah</th>
                                    <td><?php echo $row['telepon_ayah']; ?></td>
                                </tr>
                            </table>

                            <h5 class="mt-4">Berkas</h5>
                            <div class="form-group">
                                <?php if (!empty($row['berkas'])): ?>
                                    <embed src="../../../storage/berkas/<?php echo $row['berkas']; ?>" type="application/pdf" width="100%" height="400px">
                                <?php else: ?>
                                    <p>Belum ada berkas yang diupload.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <a href="index.php" class="btn btn-secondary">Kembali ke Daftar Pendaftaran</a>
                </div>
            </div>
        </div>
    </div>

    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="../js/sb-admin-2.min.js"></script>

</body>

</html>
