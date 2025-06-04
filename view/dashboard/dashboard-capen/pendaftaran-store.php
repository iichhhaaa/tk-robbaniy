<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['nama'])) {
    // If not logged in, redirect to login page
    header('Location: ../../../login.php');
    exit();
}

// Check if the user role is 'capen'
if ($_SESSION['role'] !== 'capen') {
    // If role is not 'capen', redirect to capen dashboard
    header('Location: ../dashboard-capen/index.php');
    exit();
}

$user_id = $_SESSION['id'];

include '../../../koneksi.php';  // Connect to the database

// Get data from the form
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

$uploadDir = '../../../storage/berkas/';  // File storage folder

// Generate a unique file name using uniqid() and rand()
$unique_name = uniqid('berkas_', true) . rand(1000, 9999) . '.' . strtolower(pathinfo($_FILES["berkas"]["name"], PATHINFO_EXTENSION));

// Define the target file with the unique name
$targetFile = $uploadDir . $unique_name;

// Variable to track upload status
$uploadOk = 1;

// Get the file extension
$imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

// Check if the file is an image (although only PDF is accepted, this is still checked)
if (isset($_POST["submit"])) {
    $check = getimagesize($_FILES["berkas"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File bukan gambar."; // File is not an image
        $uploadOk = 0;
    }
}

// Check if file already exists
if (file_exists($targetFile)) {
    echo "File sudah ada."; // File already exists
    $uploadOk = 0;
}

// Check file size (Max 5MB)
if ($_FILES["berkas"]["size"] > 5000000) {
    echo "File terlalu besar."; // File is too large
    $uploadOk = 0;
}

// Validate allowed file type (only PDF is allowed)
if ($imageFileType != "pdf") {
    echo "Hanya file PDF yang diperbolehkan."; // Only PDF files are allowed
    $uploadOk = 0;
}

// If uploadOk is 0, do not upload the file
if ($uploadOk == 0) {
    echo "Maaf, file Anda tidak bisa diupload."; // Sorry, your file could not be uploaded
} else {
    // If everything is valid, attempt to upload the file
    if (move_uploaded_file($_FILES["berkas"]["tmp_name"], $targetFile)) {
        echo "File ". htmlspecialchars($unique_name) . " telah diupload."; // File has been uploaded
    } else {
        echo "Terjadi kesalahan saat mengupload file."; // Error uploading the file
    }
}

// Save student's data
$sqlMurid = "INSERT INTO tk_robbaniy.murid (nama, tempat_lahir, tanggal_lahir, nik, no_akte, jenis_kelamin, anak_ke, alamat, telepon, riwayat_kesehatan)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

if ($stmt = $conn->prepare($sqlMurid)) {
    $stmt->bind_param("ssssssisss", $nama_murid, $tempat_lahir_murid, $tanggal_lahir_murid, $nik_murid, $no_akte_murid, $jenis_kelamin_murid, $anak_ke_murid, $alamat_murid, $telepon_murid, $riwayat_kesehatan_murid);
    if ($stmt->execute()) {
        $murid_id = $stmt->insert_id; // Get the ID of the inserted student
        $stmt->close();
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Save mother's data
$sqlIbu = "INSERT INTO tk_robbaniy.ibu (nama, tempat_lahir, tanggal_lahir, nik, agama, pekerjaan, penghasilan, alamat, telepon) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

if ($stmt = $conn->prepare($sqlIbu)) {
    $stmt->bind_param("ssssssiss", $nama_ibu, $tempat_lahir_ibu, $tanggal_lahir_ibu, $nik_ibu, $agama_ibu, $pekerjaan_ibu, $penghasilan_ibu, $alamat_ibu, $telepon_ibu);
    if ($stmt->execute()) {
        $ibu_id = $stmt->insert_id; // Get the ID of the inserted mother
        $stmt->close();
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Save father's data
$sqlAyah = "INSERT INTO tk_robbaniy.ayah (nama, tempat_lahir, tanggal_lahir, nik, agama, pekerjaan, penghasilan, alamat, telepon) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

if ($stmt = $conn->prepare($sqlAyah)) {
    $stmt->bind_param("ssssssiss", $nama_ayah, $tempat_lahir_ayah, $tanggal_lahir_ayah, $nik_ayah, $agama_ayah, $pekerjaan_ayah, $penghasilan_ayah, $alamat_ayah, $telepon_ayah);
    if ($stmt->execute()) {
        $ayah_id = $stmt->insert_id; // Get the ID of the inserted father
        $stmt->close();
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Save registration data
$kode_pendaftaran = "PSR-".date('Y').uniqid(); // Generate unique registration code
$sqlPendaftaran = "INSERT INTO tk_robbaniy.pendaftaran (kode_pendaftaran, murid_id, ayah_id, ibu_id, berkas, user_id)
VALUES (?, ?, ?, ?, ?, ?)";

if ($stmt = $conn->prepare($sqlPendaftaran)) {
    $stmt->bind_param("siiisi", $kode_pendaftaran, $murid_id, $ayah_id, $ibu_id, $unique_name, $user_id);
    if ($stmt->execute()) {
        // Redirect to index page with success status
        header("Location: index.php?status=success");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>