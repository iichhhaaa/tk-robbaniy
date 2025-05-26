<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['nama'])) {
    // If not logged in, redirect to login page
    header('Location: ../../../login.php');
    exit();
}

if ($_SESSION['role'] !== 'admin') {
    // If not logged in or role is not admin, redirect to dashboard
    header('Location: ../dashboard-capen/index.php');
    exit();
}

// Cek jika ada ID pendaftaran yang dikirim
if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit();
}

$nama = $_SESSION['nama'];

// Ambil ID pendaftaran dari URL
$id_pendaftaran = $_GET['id'];

// Koneksi ke database
include '../../../koneksi.php';

// Ambil data pendaftaran berdasarkan ID
$sql = "SELECT p.id AS id, p.kode_pendaftaran, p.berkas, m.nama AS nama_murid, a.nama AS nama_ayah, i.nama AS nama_ibu, 
        m.tempat_lahir AS tempat_lahir_murid, m.tanggal_lahir AS tanggal_lahir_murid,m.id AS murid_id, m.nik AS nik_murid, 
        m.no_akte AS no_akte_murid, m.jenis_kelamin AS jenis_kelamin_murid, m.anak_ke AS anak_ke_murid, 
        m.alamat AS alamat_murid, m.telepon AS telepon_murid, m.riwayat_kesehatan AS riwayat_kesehatan_murid,
        i.id AS ibu_id, i.nama AS nama_ibu, i.tempat_lahir AS tempat_lahir_ibu, i.tanggal_lahir AS tanggal_lahir_ibu, i.nik AS nik_ibu, 
        i.agama AS agama_ibu, i.pekerjaan AS pekerjaan_ibu, i.penghasilan AS penghasilan_ibu, i.alamat AS alamat_ibu,
        i.telepon AS telepon_ibu, a.id AS ayah_id, a.nama AS nama_ayah, a.tempat_lahir AS tempat_lahir_ayah, a.tanggal_lahir AS tanggal_lahir_ayah, 
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
    <title>Ubah Data Pendaftaran</title>
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
                    <h1 class="h3 mb-4 text-gray-800">Ubah Data Pendaftaran</h1>

                    <form id="pendaftaranForm" action="update-store.php" method="POST" enctype="multipart/form-data">
                        <input type="text" name="id" id="id" hidden value="<?php echo $row['id']; ?>">
                        <input type="text" name="kode_pendaftaran" id="kode_pendaftaran" hidden value="<?php echo $row['kode_pendaftaran']; ?>">
                        <!-- Step 1: Data Murid -->
                        <div id="step1">
                            <h5 class="mt-4">Data Murid</h5>
                            <input type="text" name="murid_id" id="murid_id" hidden value="<?php echo $row['murid_id']; ?>">
                            <div class="form-group">
                                <label for="nama_murid">Nama Lengkap Murid</label>
                                <input value="<?php echo $row['nama_murid']; ?>" type="text" class="form-control" id="nama_murid" name="nama_murid" placeholder="Masukkan Nama Lengkap Murid" required>
                            </div>
                            <div class="form-group">
                                <label for="tempat_lahir_murid">Tempat Lahir</label>
                                <input value="<?php echo $row['tempat_lahir_murid']; ?>" type="text" class="form-control" id="tempat_lahir_murid" name="tempat_lahir_murid" placeholder="Masukkan Tempat Lahir" required>
                            </div>
                            <div class="form-group">
                                <label for="tanggal_lahir_murid">Tanggal Lahir</label>
                                <input value="<?php echo $row['tanggal_lahir_murid']; ?>" type="date" class="form-control" id="tanggal_lahir_murid" name="tanggal_lahir_murid" required>
                            </div>
                            <div class="form-group">
                                <label for="nik_murid">Nomor Induk Kependudukan</label>
                                <input value="<?php echo $row['nik_murid']; ?>" type="text" class="form-control" id="nik_murid" name="nik_murid" placeholder="Masukkan NIK Murid" required>
                            </div>
                            <div class="form-group">
                                <label for="no_akte_murid">Nomor Akta Kelahiran</label>
                                <input value="<?php echo $row['no_akte_murid']; ?>" type="text" class="form-control" id="no_akte_murid" name="no_akte_murid" placeholder="Masukkan Nomor Akta Kelahiran" required>
                            </div>
                            <div class="form-group">
                                <label for="jenis_kelamin_murid">Jenis Kelamin</label>
                                <select class="form-control" id="jenis_kelamin_murid" name="jenis_kelamin_murid" required>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="anak_ke_murid">Anak Ke-berapa</label>
                                <input value="<?php echo $row['anak_ke_murid']; ?>" type="number" class="form-control" id="anak_ke_murid" name="anak_ke_murid" placeholder="Masukkan Anak Ke-berapa" required>
                            </div>
                            <div class="form-group">
                                <label for="alamat_murid">Alamat</label>
                                <textarea class="form-control" id="alamat_murid" name="alamat_murid" rows="3" placeholder="Masukkan Alamat Lengkap" required><?php echo $row['alamat_murid']; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="telepon_murid">Nomor Telepon</label>
                                <input value="<?php echo $row['telepon_murid']; ?>" type="text" class="form-control" id="telepon_murid" name="telepon_murid" placeholder="Masukkan Nomor Telepon" required>
                            </div>
                            <div class="form-group">
                                <label for="riwayat_kesehatan_murid">Riwayat Kesehatan</label>
                                <textarea class="form-control" id="riwayat_kesehatan_murid" name="riwayat_kesehatan_murid" rows="3" placeholder="Masukkan Riwayat Kesehatan" required><?php echo $row['riwayat_kesehatan_murid']; ?></textarea>
                            </div>
                            <button type="button" class="btn btn-primary float-right mt-4" id="nextStep1">Lanjut</button>
                        </div>

                        <!-- Step 2: Data Ibu -->
                        <div id="step2" style="display:none;">
                            <h5 class="mt-4">Data Ibu</h5>
                            <input type="text" name="ibu_id" id="ibu_id" hidden value="<?php echo $row['ibu_id']; ?>">
                            <div class="form-group">
                                <label for="nama_ibu">Nama Lengkap Ibu</label>
                                <input value="<?php echo $row['nama_ibu']; ?>" type="text" class="form-control" id="nama_ibu" name="nama_ibu" placeholder="Masukkan Nama Lengkap Ibu" required>
                            </div>
                            <div class="form-group">
                                <label for="tempat_lahir_ibu">Tempat Lahir Ibu</label>
                                <input value="<?php echo $row['tempat_lahir_ibu']; ?> " type="text" class="form-control" id="tempat_lahir_ibu" name="tempat_lahir_ibu" placeholder="Masukkan Tempat Lahir Ibu" required>
                            </div>
                            <div class="form-group">
                                <label for="tanggal_lahir_ibu">Tanggal Lahir Ibu</label>
                                <input value="<?php echo $row['tanggal_lahir_ibu']; ?>" type="date" class="form-control" id="tanggal_lahir_ibu" name="tanggal_lahir_ibu" required>
                            </div>
                            <div class="form-group">
                                <label for="nik_ibu">Nomor Induk Kependudukan Ibu</label>
                                <input value="<?php echo $row['nik_ibu']; ?>" type="text" class="form-control" id="nik_ibu" name="nik_ibu" placeholder="Masukkan NIK Ibu" required>
                            </div>
                            <div class="form-group">
                                <label for="agama_ibu">Agama Ibu</label>
                                <input value="<?php echo $row['agama_ibu']; ?>" type="text" class="form-control" id="agama_ibu" name="agama_ibu" placeholder="Masukkan Agama Ibu" required>
                            </div>
                            <div class="form-group">
                                <label for="pekerjaan_ibu">Pekerjaan Ibu</label>
                                <input value="<?php echo $row['pekerjaan_ibu']; ?>" type="text" class="form-control" id="pekerjaan_ibu" name="pekerjaan_ibu" placeholder="Masukkan Pekerjaan Ibu" required>
                            </div>
                            <div class="form-group">
                                <label for="penghasilan_ibu">Penghasilan Ibu</label>
                                <input value="<?php echo $row['penghasilan_ibu']; ?>" type="number" class="form-control" id="penghasilan_ibu" name="penghasilan_ibu" placeholder="Masukkan Penghasilan Ibu" required>
                            </div>
                            <div class="form-group">
                                <label for="alamat_ibu">Alamat Ibu</label>
                                <textarea class="form-control" id="alamat_ibu" name="alamat_ibu" rows="3" placeholder="Masukkan Alamat Ibu" required><?php echo $row['alamat_ibu']; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="telepon_ibu">Nomor Telepon Ibu</label>
                                <input value="<?php echo $row['telepon_ibu']; ?>" type="text" class="form-control" id="telepon_ibu" name="telepon_ibu" placeholder="Masukkan Nomor Telepon Ibu" required>
                            </div>
                            <button type="button" class="btn btn-secondary float-left mt-4" id="prevStep2">Kembali</button>
                            <button type="button" class="btn btn-primary float-right mt-4" id="nextStep2">Lanjut</button>
                        </div>

                        <!-- Step 3: Data Ayah -->
                        <div id="step3" style="display:none;">
                            <h5 class="mt-4">Data Ayah</h5>
                            <input type="text" name="ayah_id" id="ayah_id" hidden value="<?php echo $row['ayah_id']; ?>">
                            <div class="form-group">
                                <label for="nama_ayah">Nama Lengkap Ayah</label>
                                <input value="<?php echo $row['nama_ayah']; ?>" type="text" class="form-control" id="nama_ayah" name="nama_ayah" placeholder="Masukkan Nama Lengkap Ayah" required>
                            </div>
                            <div class="form-group">
                                <label for="tempat_lahir_ayah">Tempat Lahir Ayah</label>
                                <input value="<?php echo $row['tempat_lahir_ayah']; ?>" type="text" class="form-control" id="tempat_lahir_ayah" name="tempat_lahir_ayah" placeholder="Masukkan Tempat Lahir Ayah" required>
                            </div>
                            <div class="form-group">
                                <label for="tanggal_lahir_ayah">Tanggal Lahir Ayah</label>
                                <input value="<?php echo $row['tanggal_lahir_ayah']; ?>" type="date" class="form-control" id="tanggal_lahir_ayah" name="tanggal_lahir_ayah" required>
                            </div>
                            <div class="form-group">
                                <label for="nik_ayah">Nomor Induk Kependudukan Ayah</label>
                                <input value="<?php echo $row['nik_ayah']; ?>" type="text" class="form-control" id="nik_ayah" name="nik_ayah" placeholder="Masukkan NIK Ayah" required>
                            </div>
                            <div class="form-group">
                                <label for="agama_ibu">Agama ayah</label>
                                <input value="<?php echo $row['agama_ibu']; ?>" type="text" class="form-control" id="agama_ayah" name="agama_ayah" placeholder="Masukkan Agama ayah" required>
                            </div>
                            <div class="form-group">
                                <label for="pekerjaan_ayah">Pekerjaan ayah</label>
                                <input value="<?php echo $row['pekerjaan_ayah']; ?>" type="text" class="form-control" id="pekerjaan_ayah" name="pekerjaan_ayah" placeholder="Masukkan Pekerjaan ayah" required>
                            </div>
                            <div class="form-group">
                                <label for="penghasilan_ayah">Penghasilan ayah</label>
                                <input value="<?php echo $row['penghasilan_ayah']; ?>" type="number" class="form-control" id="penghasilan_ayah" name="penghasilan_ayah" placeholder="Masukkan Penghasilan ayah" required>
                            </div>
                            <div class="form-group">
                                <label for="alamat_ayah">Alamat ayah</label>
                                <textarea class="form-control" id="alamat_ayah" name="alamat_ayah" rows="3" placeholder="Masukkan Alamat Ayah" required><?php echo $row['alamat_ayah']; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="telepon_ayah">Nomor Telepon ayah</label>
                                <input value="<?php echo $row['telepon_ayah']; ?>" type="text" class="form-control" id="telepon_ayah" name="telepon_ayah" placeholder="Masukkan Nomor Telepon ayah" required>
                            </div>
                            <button type="button" class="btn btn-secondary float-left mt-4" id="prevStep3">Kembali</button>
                            <button type="button" class="btn btn-primary float-right mt-4" id="nextStep3">Lanjut</button>
                        </div>

                        <!-- Step 4: Upload Berkas -->
                        <div id="step4" style="display:none;">
                            <h5 class="mt-4">Upload Berkas</h5>
                            <div class="form-group">
                                <label for="berkas">Pilih Berkas untuk Diupload</label>
                                <input type="file" class="form-control" id="berkas" name="berkas" accept="application/pdf" onchange="previewFile(event)">
                            </div>

                            <!-- Preview PDF -->
                            <div id="pdfPreview" style="display:none;">
                                <h6>Preview PDF Baru</h6>
                                <embed id="pdfPreviewEmbed" src="" type="application/pdf" width="100%" height="400px">
                            </div>

                            <!-- Display the old PDF file (if exists) -->
                            <?php if (!empty($row['berkas'])): ?>
                                <h6>File yang sudah diupload:</h6>
                                <?php if (pathinfo($row['berkas'], PATHINFO_EXTENSION) == 'pdf'): ?>
                                    <embed src="../../../storage/berkas/<?php echo $row['berkas']; ?>" type="application/pdf" width="100%" height="400px">
                                <?php endif; ?>
                            <?php endif; ?>

                            <button type="button" class="btn btn-secondary float-left mt-4" id="prevStep4">Kembali</button>
                            <button type="submit" class="btn btn-primary float-right mt-4">Kirim</button>
                        </div>



                    </form>
                </div>
            </div>
            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>&copy; <?= date('Y'); ?> TK Islam Robbaniy</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->
        </div>
    </div>

    <script>
        // Next Step 1: Go to step 2
        document.getElementById('nextStep1').addEventListener('click', function() {
            document.getElementById('step1').style.display = 'none';
            document.getElementById('step2').style.display = 'block';
        });

        // Previous Step 2: Go back to step 1
        document.getElementById('prevStep2').addEventListener('click', function() {
            document.getElementById('step2').style.display = 'none';
            document.getElementById('step1').style.display = 'block';
        });

        // Next Step 2: Go to step 3
        document.getElementById('nextStep2').addEventListener('click', function() {
            document.getElementById('step2').style.display = 'none';
            document.getElementById('step3').style.display = 'block';
        });

        // Previous Step 3: Go back to step 2
        document.getElementById('prevStep3').addEventListener('click', function() {
            document.getElementById('step3').style.display = 'none';
            document.getElementById('step2').style.display = 'block';
        });

        // Next Step 3: Go to step 4 (Upload Berkas)
        document.getElementById('nextStep3').addEventListener('click', function() {
            document.getElementById('step3').style.display = 'none';
            document.getElementById('step4').style.display = 'block';
        });

        // Previous Step 4: Go back to step 3
        document.getElementById('prevStep4').addEventListener('click', function() {
            document.getElementById('step4').style.display = 'none';
            document.getElementById('step3').style.display = 'block';
        });

        // Function to preview file
        // Function to preview file
        function previewFile(event) {
            const file = event.target.files[0];
            const fileType = file.type;

            // Hide the current preview before showing a new one
            document.getElementById('pdfPreview').style.display = 'none';

            if (fileType === "application/pdf") {
                const reader = new FileReader();
                reader.onload = function() {
                    document.getElementById('pdfPreview').style.display = 'block';
                    document.getElementById('pdfPreviewEmbed').src = reader.result;
                };
                reader.readAsDataURL(file); // Read the PDF file as data URL for preview
            } else {
                alert("Please upload a valid PDF file.");
            }
        }
    </script>
    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../js/demo/datatables-demo.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
</body>

</html>