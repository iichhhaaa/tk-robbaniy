<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['nama'])) {
    // If not logged in, redirect to login page
    header('Location: login.php');
    exit();
}

$nama = $_SESSION['nama'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>SB Admin 2 - Tables</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
        <?php include '../inc/sidebar.php' ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
                <?php include '../inc/dashboard-header.php' ?>

                <!-- Begin Form Pendaftaran -->
                <div class="container-fluid">
                    <h1 class="h3 mb-4 text-gray-800">Form Pendaftaran Murid</h1>

                    <form id="pendaftaranForm" action="pendaftaran-store.php" method="POST" enctype="multipart/form-data">
                        <!-- Step 1: Data Murid -->
                        <div id="step1">
                            <h5 class="mt-4">Data Murid</h5>
                            <div class="form-group">
                                <label for="nama_murid">Nama Lengkap Murid</label>
                                <input type="text" class="form-control" id="nama_murid" name="nama_murid" placeholder="Masukkan Nama Lengkap Murid" required>
                            </div>
                            <div class="form-group">
                                <label for="tempat_lahir_murid">Tempat Lahir</label>
                                <input type="text" class="form-control" id="tempat_lahir_murid" name="tempat_lahir_murid" placeholder="Masukkan Tempat Lahir" required>
                            </div>
                            <div class="form-group">
                                <label for="tanggal_lahir_murid">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="tanggal_lahir_murid" name="tanggal_lahir_murid" required>
                            </div>
                            <div class="form-group">
                                <label for="nik_murid">Nomor Induk Kependudukan</label>
                                <input type="text" class="form-control" id="nik_murid" name="nik_murid" placeholder="Masukkan NIK Murid" required>
                            </div>
                            <div class="form-group">
                                <label for="no_akte_murid">Nomor Akta Kelahiran</label>
                                <input type="text" class="form-control" id="no_akte_murid" name="no_akte_murid" placeholder="Masukkan Nomor Akta Kelahiran" required>
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
                                <input type="number" class="form-control" id="anak_ke_murid" name="anak_ke_murid" placeholder="Masukkan Anak Ke-berapa" required>
                            </div>
                            <div class="form-group">
                                <label for="alamat_murid">Alamat</label>
                                <textarea class="form-control" id="alamat_murid" name="alamat_murid" rows="3" placeholder="Masukkan Alamat Lengkap" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="telepon_murid">Nomor Telepon</label>
                                <input type="text" class="form-control" id="telepon_murid" name="telepon_murid" placeholder="Masukkan Nomor Telepon" required>
                            </div>
                            <div class="form-group">
                                <label for="riwayat_kesehatan_murid">Riwayat Kesehatan</label>
                                <textarea class="form-control" id="riwayat_kesehatan_murid" name="riwayat_kesehatan_murid" rows="3" placeholder="Masukkan Riwayat Kesehatan" required></textarea>
                            </div>
                            <button type="button" class="btn btn-primary float-right mt-4" id="nextStep1">Next</button>
                        </div>

                        <!-- Step 2: Data Ibu -->
                        <div id="step2" style="display:none;">
                            <h5 class="mt-4">Data Ibu</h5>
                            <div class="form-group">
                                <label for="nama_ibu">Nama Lengkap Ibu</label>
                                <input type="text" class="form-control" id="nama_ibu" name="nama_ibu" placeholder="Masukkan Nama Lengkap Ibu" required>
                            </div>
                            <div class="form-group">
                                <label for="tempat_lahir_ibu">Tempat Lahir Ibu</label>
                                <input type="text" class="form-control" id="tempat_lahir_ibu" name="tempat_lahir_ibu" placeholder="Masukkan Tempat Lahir Ibu" required>
                            </div>
                            <div class="form-group">
                                <label for="tanggal_lahir_ibu">Tanggal Lahir Ibu</label>
                                <input type="date" class="form-control" id="tanggal_lahir_ibu" name="tanggal_lahir_ibu" required>
                            </div>
                            <div class="form-group">
                                <label for="nik_ibu">Nomor Induk Kependudukan Ibu</label>
                                <input type="text" class="form-control" id="nik_ibu" name="nik_ibu" placeholder="Masukkan NIK Ibu" required>
                            </div>
                            <div class="form-group">
                                <label for="agama_ibu">Agama Ibu</label>
                                <select class="form-control" id="agama_ibu" name="agama_ibu" required>
                                    <option value="Islam">Islam</option>
                                    <option value="Kristen">Kristen</option>
                                    <option value="Katolik">Katolik</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Buddha">Buddha</option>
                                    <option value="Konghucu">Konghucu</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="pekerjaan_ibu">Pekerjaan Ibu</label>
                                <input type="text" class="form-control" id="pekerjaan_ibu" name="pekerjaan_ibu" placeholder="Masukkan Pekerjaan Ibu" required>
                            </div>
                            <div class="form-group">
                                <label for="penghasilan_ibu">Penghasilan Ibu</label>
                                <input type="number" class="form-control" id="penghasilan_ibu" name="penghasilan_ibu" placeholder="Masukkan Penghasilan Ibu" required>
                            </div>
                            <div class="form-group">
                                <label for="alamat_ibu">Alamat Ibu</label>
                                <textarea class="form-control" id="alamat_ibu" name="alamat_ibu" rows="3" placeholder="Masukkan Alamat Ibu" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="telepon_ibu">Nomor Telepon Ibu</label>
                                <input type="text" class="form-control" id="telepon_ibu" name="telepon_ibu" placeholder="Masukkan Nomor Telepon Ibu" required>
                            </div>
                            <button type="button" class="btn btn-secondary float-left mt-4" id="prevStep2">Previous</button>
                            <button type="button" class="btn btn-primary float-right mt-4" id="nextStep2">Next</button>
                        </div>

                        <!-- Step 3: Data Ayah -->
                        <div id="step3" style="display:none;">
                            <h5 class="mt-4">Data Ayah</h5>
                            <div class="form-group">
                                <label for="nama_ayah">Nama Lengkap Ayah</label>
                                <input type="text" class="form-control" id="nama_ayah" name="nama_ayah" placeholder="Masukkan Nama Lengkap Ayah" required>
                            </div>
                            <div class="form-group">
                                <label for="tempat_lahir_ayah">Tempat Lahir Ayah</label>
                                <input type="text" class="form-control" id="tempat_lahir_ayah" name="tempat_lahir_ayah" placeholder="Masukkan Tempat Lahir Ayah" required>
                            </div>
                            <div class="form-group">
                                <label for="tanggal_lahir_ayah">Tanggal Lahir Ayah</label>
                                <input type="date" class="form-control" id="tanggal_lahir_ayah" name="tanggal_lahir_ayah" required>
                            </div>
                            <div class="form-group">
                                <label for="nik_ayah">Nomor Induk Kependudukan Ayah</label>
                                <input type="text" class="form-control" id="nik_ayah" name="nik_ayah" placeholder="Masukkan NIK Ayah" required>
                            </div>
                            <div class="form-group">
                                <label for="agama_ayah">Agama Ayah</label>
                                <select class="form-control" id="agama_ayah" name="agama_ayah" required>
                                    <option value="Islam">Islam</option>
                                    <option value="Kristen">Kristen</option>
                                    <option value="Katolik">Katolik</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Buddha">Buddha</option>
                                    <option value="Konghucu">Konghucu</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="pekerjaan_ayah">Pekerjaan ayah</label>
                                <input type="text" class="form-control" id="pekerjaan_ayah" name="pekerjaan_ayah" placeholder="Masukkan Pekerjaan ayah" required>
                            </div>
                            <div class="form-group">
                                <label for="penghasilan_ayah">Penghasilan ayah</label>
                                <input type="number" class="form-control" id="penghasilan_ayah" name="penghasilan_ayah" placeholder="Masukkan Penghasilan ayah" required>
                            </div>
                            <div class="form-group">
                                <label for="alamat_ayah">Alamat ayah</label>
                                <textarea class="form-control" id="alamat_ayah" name="alamat_ayah" rows="3" placeholder="Masukkan Alamat ayah" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="telepon_ayah">Nomor Telepon ayah</label>
                                <input type="text" class="form-control" id="telepon_ayah" name="telepon_ayah" placeholder="Masukkan Nomor Telepon ayah" required>
                            </div>
                            <button type="button" class="btn btn-secondary float-left mt-4" id="prevStep3">Previous</button>
                            <button type="button" class="btn btn-primary float-right mt-4" id="nextStep3">Next</button>
                        </div>

                        <!-- Step 4: Upload Berkas -->
                        <div id="step4" style="display:none;">
                            <h5 class="mt-4">Upload Berkas</h5>
                            <div class="form-group">
                                <label for="berkas">Pilih Berkas untuk Diupload</label>
                                <input type="file" class="form-control" id="berkas" name="berkas" accept="application/pdf" onchange="previewFile(event)" required>
                            </div>


                            <!-- Preview PDF -->
                            <div id="pdfPreview" style="display:none;">
                                <h6>Preview PDF</h6>
                                <embed id="pdfPreviewEmbed" src="" type="application/pdf" width="100%" height="400px">
                            </div>

                            <button type="button" class="btn btn-secondary float-left mt-4" id="prevStep4">Previous</button>
                            <button type="submit" class="btn btn-primary float-right mt-4" id="submitBtn">Submit</button>
                        </div>

                    </form>
                </div>
                <!-- End Form Pendaftaran -->
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <!-- <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2020</span>
                    </div>
                </div>
            </footer> -->
            <!-- End of Footer -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Javascript to handle steps, file preview and form submission -->

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
        function previewFile(event) {
            const file = event.target.files[0];
            const fileType = file.type;
            if (fileType === "application/pdf") {
                const reader = new FileReader();
                reader.onload = function() {
                    document.getElementById('pdfPreview').style.display = 'block';
                    document.getElementById('pdfPreviewEmbed').src = reader.result;
                };
                reader.readAsDataURL(file);
            } else {
                alert("Please upload a valid image or PDF file.");
                document.getElementById('pdfPreview').style.display = 'none';
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