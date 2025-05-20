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

$user_id = $_SESSION['id'];

include '../../../koneksi.php';  // Koneksi ke database

// Mendapatkan data dari form
$nama_murid = $_POST['nama_murid'];
$tempat_lahir_murid = $_POST['tempat_lahir_murid'];
$tanggal_lahir_murid = $_POST['tanggal_lahir_murid'];
$nik_murid = $_POST['nik_murid'];
$no_akte_murid = $_POST['no_akte_murid'];
$jenis_kelamin_murid = $_POST['jenis_kelamin_murid'];
$anak_ke_murid = $_POST['anak_ke_murid'];
$alamat_murid = $_POST['alamat_murid'];
$telepon_murid = $_POST['telepon_murid'];
$riwayat_kesehatan_murid = $_POST['riwayat_kesehatan_murid'];

$nama_ibu = $_POST['nama_ibu'];
$tempat_lahir_ibu = $_POST['tempat_lahir_ibu'];
$tanggal_lahir_ibu = $_POST['tanggal_lahir_ibu'];
$nik_ibu = $_POST['nik_ibu'];
$agama_ibu = $_POST['agama_ibu'];
$pekerjaan_ibu = $_POST['pekerjaan_ibu'];
$penghasilan_ibu = $_POST['penghasilan_ibu'];
$alamat_ibu = $_POST['alamat_ibu'];
$telepon_ibu = $_POST['telepon_ibu'];

$nama_ayah = $_POST['nama_ayah'];
$tempat_lahir_ayah = $_POST['tempat_lahir_ayah'];
$tanggal_lahir_ayah = $_POST['tanggal_lahir_ayah'];
$nik_ayah = $_POST['nik_ayah'];
$agama_ayah = $_POST['agama_ayah'];
$pekerjaan_ayah = $_POST['pekerjaan_ayah'];
$penghasilan_ayah = $_POST['penghasilan_ayah'];
$alamat_ayah = $_POST['alamat_ayah'];
$telepon_ayah = $_POST['telepon_ayah'];

$uploadDir = '../../../storage/berkas/';  // Tentukan folder penyimpanan berkas

// Menghasilkan nama file unik menggunakan uniqid() dan rand()
$unique_name = uniqid('berkas_', true) . rand(1000, 9999) . '.' . strtolower(pathinfo($_FILES["berkas"]["name"], PATHINFO_EXTENSION));

// Tentukan target file dengan nama file unik
$targetFile = $uploadDir . $unique_name;

// Variabel untuk menentukan status upload
$uploadOk = 1;

// Dapatkan ekstensi file
$imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

// Cek apakah file gambar atau bukan
if (isset($_POST["submit"])) {
    $check = getimagesize($_FILES["berkas"]["tmp_name"]);  // Periksa file apakah gambar
    if ($check !== false) {
        // Jika file adalah gambar
        $uploadOk = 1;
    } else {
        // Jika file bukan gambar
        echo "File bukan gambar.";
        $uploadOk = 0;
    }
}

// Cek jika file sudah ada
if (file_exists($targetFile)) {
    echo "File sudah ada.";
    $uploadOk = 0;
}

// Cek ukuran file (Maksimum 5MB)
if ($_FILES["berkas"]["size"] > 5000000) {
    echo "File terlalu besar.";
    $uploadOk = 0;
}

// Validasi jenis file yang diterima (Hanya PDF yang diperbolehkan)
if ($imageFileType != "pdf") {
    echo "Hanya file PDF yang diperbolehkan.";
    $uploadOk = 0;
}

// Jika uploadOk == 0, maka file tidak akan diupload
if ($uploadOk == 0) {
    echo "Maaf, file Anda tidak bisa diupload.";
} else {
    // Jika semuanya valid, upload file
    if (move_uploaded_file($_FILES["berkas"]["tmp_name"], $targetFile)) {
        echo "File ". htmlspecialchars($unique_name) . " telah diupload.";
    } else {
        // Jika terjadi error saat mengupload file
        echo "Terjadi kesalahan saat mengupload file.";
    }
}

// Menyimpan data Murid
$sqlMurid = "INSERT INTO tk_robbaniy.murid (nama, tempat_lahir, tanggal_lahir, nik, no_akte, jenis_kelamin, anak_ke, alamat, telepon, riwayat_kesehatan)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

if ($stmt = $conn->prepare($sqlMurid)) {
    // Bind parameters
    $stmt->bind_param("ssssssisss", $nama_murid, $tempat_lahir_murid, $tanggal_lahir_murid, $nik_murid, $no_akte_murid, $jenis_kelamin_murid, $anak_ke_murid, $alamat_murid, $telepon_murid, $riwayat_kesehatan_murid);
    
    // Execute the query
    if ($stmt->execute()) {
        $murid_id = $stmt->insert_id; // Ambil ID Murid yang baru disimpan
        $stmt->close();
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Menyimpan data Ibu
$sqlIbu = "INSERT INTO tk_robbaniy.ibu (nama, tempat_lahir, tanggal_lahir, nik, agama, pekerjaan, penghasilan, alamat, telepon) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

if ($stmt = $conn->prepare($sqlIbu)) {
    // Bind parameters
    $stmt->bind_param("ssssssiss", $nama_ibu, $tempat_lahir_ibu, $tanggal_lahir_ibu, $nik_ibu, $agama_ibu, $pekerjaan_ibu, $penghasilan_ibu, $alamat_ibu, $telepon_ibu);
    
    // Execute the query
    if ($stmt->execute()) {
        $ibu_id = $stmt->insert_id; // Ambil ID Ibu yang baru disimpan
        $stmt->close();
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Menyimpan data Ayah
$sqlAyah = "INSERT INTO tk_robbaniy.ayah (nama, tempat_lahir, tanggal_lahir, nik, agama, pekerjaan, penghasilan, alamat, telepon) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

if ($stmt = $conn->prepare($sqlAyah)) {
    // Bind parameters
    $stmt->bind_param("ssssssiss", $nama_ayah, $tempat_lahir_ayah, $tanggal_lahir_ayah, $nik_ayah, $agama_ayah, $pekerjaan_ayah, $penghasilan_ayah, $alamat_ayah, $telepon_ayah);
    
    // Execute the query
    if ($stmt->execute()) {
        $ayah_id = $stmt->insert_id; // Ambil ID Ayah yang baru disimpan
        $stmt->close();
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Menyimpan data Pendaftaran
$kode_pendaftaran = "PSR-".date('Y').uniqid(); // Membuat kode pendaftaran unik
$sqlPendaftaran = "INSERT INTO tk_robbaniy.pendaftaran (kode_pendaftaran, murid_id, ayah_id, ibu_id, berkas, user_id)
VALUES (?, ?, ?, ?, ?, ?)";

if ($stmt = $conn->prepare($sqlPendaftaran)) {
    // Bind parameters
    $stmt->bind_param("siiisi", $kode_pendaftaran, $murid_id, $ayah_id, $ibu_id, $unique_name, $user_id);
    
    // Execute the query
    if ($stmt->execute()) {
        // Redirect to index.php with status=success
        header("Location: index.php?status=success");
        exit();  // Ensure the script stops after redirection
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

$conn->close();
?>
