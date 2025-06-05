<?php
session_start();

// Redirect to login if user session not set
if (!isset($_SESSION['nama'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['id'];

include '../../../koneksi.php';  // Include database connection

// Retrieve data from submitted form
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

$uploadDir = '../../../storage/berkas/';  // Define the upload path

// Generate unique file name
$unique_name = uniqid('berkas_', true) . rand(1000, 9999) . '.' . strtolower(pathinfo($_FILES["berkas"]["name"], PATHINFO_EXTENSION));

// Define full target path
$targetFile = $uploadDir . $unique_name;

// Flag to check upload validity
$uploadOk = 1;

// Determine the file extension
$imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

// Check if file is an actual image
if (isset($_POST["submit"])) {
    $check = getimagesize($_FILES["berkas"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File bukan gambar.";
        $uploadOk = 0;
    }
}

// Prevent overwriting existing file
if (file_exists($targetFile)) {
    echo "File sudah ada.";
    $uploadOk = 0;
}

// Limit file size to 5MB
if ($_FILES["berkas"]["size"] > 5000000) {
    echo "Ukuran file terlalu besar. Maksimal 5MB.";
    $uploadOk = 0;
}

// Allow only PDF file types
if ($imageFileType != "pdf") {
    echo "Hanya file dengan format PDF yang diperbolehkan.";
    $uploadOk = 0;
}

// Upload process
if ($uploadOk == 0) {
    echo "Maaf, file Anda tidak dapat diunggah.";
} else {
    if (move_uploaded_file($_FILES["berkas"]["tmp_name"], $targetFile)) {
        echo "File " . htmlspecialchars($unique_name) . " berhasil diunggah.";
    } else {
        echo "Terjadi kesalahan saat mengunggah file.";
    }
}

// Insert student (murid) data
$sqlMurid = "INSERT INTO tk_robbaniy.murid (nama, tempat_lahir, tanggal_lahir, nik, no_akte, jenis_kelamin, anak_ke, alamat, telepon, riwayat_kesehatan)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

if ($stmt = $conn->prepare($sqlMurid)) {
    $stmt->bind_param("ssssssisss", $nama_murid, $tempat_lahir_murid, $tanggal_lahir_murid, $nik_murid, $no_akte_murid, $jenis_kelamin_murid, $anak_ke_murid, $alamat_murid, $telepon_murid, $riwayat_kesehatan_murid);
    
    if ($stmt->execute()) {
        $murid_id = $stmt->insert_id; // Get the inserted student's ID
        $stmt->close();
    } else {
        echo "Terjadi kesalahan saat menyimpan data murid: " . $stmt->error;
    }
}

// Insert mother's (ibu) data
$sqlIbu = "INSERT INTO tk_robbaniy.ibu (nama, tempat_lahir, tanggal_lahir, nik, agama, pekerjaan, penghasilan, alamat, telepon) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

if ($stmt = $conn->prepare($sqlIbu)) {
    $stmt->bind_param("ssssssiss", $nama_ibu, $tempat_lahir_ibu, $tanggal_lahir_ibu, $nik_ibu, $agama_ibu, $pekerjaan_ibu, $penghasilan_ibu, $alamat_ibu, $telepon_ibu);
    
    if ($stmt->execute()) {
        $ibu_id = $stmt->insert_id; // Get the inserted mother's ID
        $stmt->close();
    } else {
        echo "Terjadi kesalahan saat menyimpan data ibu: " . $stmt->error;
    }
}

// Insert father's (ayah) data
$sqlAyah = "INSERT INTO tk_robbaniy.ayah (nama, tempat_lahir, tanggal_lahir, nik, agama, pekerjaan, penghasilan, alamat, telepon) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

if ($stmt = $conn->prepare($sqlAyah)) {
    $stmt->bind_param("ssssssiss", $nama_ayah, $tempat_lahir_ayah, $tanggal_lahir_ayah, $nik_ayah, $agama_ayah, $pekerjaan_ayah, $penghasilan_ayah, $alamat_ayah, $telepon_ayah);
    
    if ($stmt->execute()) {
        $ayah_id = $stmt->insert_id; // Get the inserted father's ID
        $stmt->close();
    } else {
        echo "Terjadi kesalahan saat menyimpan data ayah: " . $stmt->error;
    }
}

// Generate registration code and save final registration data
$kode_pendaftaran = "PSR-" . date('Y') . uniqid();

$sqlPendaftaran = "INSERT INTO tk_robbaniy.pendaftaran (kode_pendaftaran, murid_id, ayah_id, ibu_id, berkas, user_id)
VALUES (?, ?, ?, ?, ?, ?)";

if ($stmt = $conn->prepare($sqlPendaftaran)) {
    $stmt->bind_param("siiisi", $kode_pendaftaran, $murid_id, $ayah_id, $ibu_id, $unique_name, $user_id);
    
    if ($stmt->execute()) {
        header("Location: index.php?status=success");
        exit();
    } else {
        echo "Terjadi kesalahan saat menyimpan data pendaftaran: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>