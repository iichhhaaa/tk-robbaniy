<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['nama'])) {
    // If not logged in, redirect to login page
    header('Location: ../../../login.php');
    exit();
}

$user_id = $_SESSION['id'];

include '../../../koneksi.php';  // Connect to the database

// Retrieve data from POST form
$id = $_POST['id'];  // Registration ID to be updated
$kode_pendaftaran = $_POST['kode_pendaftaran'];

// Student data
$murid_id = $_POST['murid_id'];
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

// Mother data
$ibu_id = $_POST['ibu_id'];
$nama_ibu = $_POST['nama_ibu'];
$tempat_lahir_ibu = $_POST['tempat_lahir_ibu'];
$tanggal_lahir_ibu = $_POST['tanggal_lahir_ibu'];
$nik_ibu = $_POST['nik_ibu'];
$agama_ibu = $_POST['agama_ibu'];
$pekerjaan_ibu = $_POST['pekerjaan_ibu'];
$penghasilan_ibu = $_POST['penghasilan_ibu'];
$alamat_ibu = $_POST['alamat_ibu'];
$telepon_ibu = $_POST['telepon_ibu'];

// Father data
$ayah_id = $_POST['ayah_id'];
$nama_ayah = $_POST['nama_ayah'];
$tempat_lahir_ayah = $_POST['tempat_lahir_ayah'];
$tanggal_lahir_ayah = $_POST['tanggal_lahir_ayah'];
$nik_ayah = $_POST['nik_ayah'];
$agama_ayah = $_POST['agama_ayah'];
$pekerjaan_ayah = $_POST['pekerjaan_ayah'];
$penghasilan_ayah = $_POST['penghasilan_ayah'];
$alamat_ayah = $_POST['alamat_ayah'];
$telepon_ayah = $_POST['telepon_ayah'];

// File upload directory
$uploadDir = '../../../storage/berkas/';

// Get the old file name from the database
$existing_file = '';
$sqlSelect = "SELECT berkas FROM tk_robbaniy.pendaftaran WHERE id = ?";
if ($stmtSelect = $conn->prepare($sqlSelect)) {
    $stmtSelect->bind_param("i", $id);
    $stmtSelect->execute();
    $stmtSelect->bind_result($existing_file);
    $stmtSelect->fetch();
    $stmtSelect->close();
}

// Set default file name to existing one
$unique_name = $existing_file;

// If a new file is uploaded, generate a new unique file name
if (isset($_FILES["berkas"]) && $_FILES["berkas"]["error"] == 0) {
    $unique_name = uniqid('berkas_', true) . rand(1000, 9999) . '.' . strtolower(pathinfo($_FILES["berkas"]["name"], PATHINFO_EXTENSION));
    $targetFile = $uploadDir . $unique_name;

    // Delete the old file if it exists and is different from the new one
    if (!empty($existing_file) && file_exists($uploadDir . $existing_file)) {
        unlink($uploadDir . $existing_file);
    }

    // Upload the new file
    if (!move_uploaded_file($_FILES["berkas"]["tmp_name"], $targetFile)) {
        echo "Terjadi kesalahan saat mengupload file."; // Error message for user
        exit();
    }
}

// Update student (murid) data
$sqlMurid = "UPDATE tk_robbaniy.murid SET nama = ?, tempat_lahir = ?, tanggal_lahir = ?, nik = ?, no_akte = ?, jenis_kelamin = ?, anak_ke = ?, alamat = ?, telepon = ?, riwayat_kesehatan = ? WHERE id = ?";
if ($stmt = $conn->prepare($sqlMurid)) {
    $stmt->bind_param("ssssssisssi", $nama_murid, $tempat_lahir_murid, $tanggal_lahir_murid, $nik_murid, $no_akte_murid, $jenis_kelamin_murid, $anak_ke_murid, $alamat_murid, $telepon_murid, $riwayat_kesehatan_murid, $murid_id);
    if (!$stmt->execute()) {
        echo "Error update murid: " . $stmt->error;
        exit();
    }
    $stmt->close();
} else {
    echo "Error prepare murid: " . $conn->error;
    exit();
}

// Update mother (ibu) data
$sqlIbu = "UPDATE tk_robbaniy.ibu SET nama = ?, tempat_lahir = ?, tanggal_lahir = ?, nik = ?, agama = ?, pekerjaan = ?, penghasilan = ?, alamat = ?, telepon = ? WHERE id = ?";
if ($stmt = $conn->prepare($sqlIbu)) {
    $stmt->bind_param("ssssssissi", $nama_ibu, $tempat_lahir_ibu, $tanggal_lahir_ibu, $nik_ibu, $agama_ibu, $pekerjaan_ibu, $penghasilan_ibu, $alamat_ibu, $telepon_ibu, $ibu_id);
    if (!$stmt->execute()) {
        echo "Error update ibu: " . $stmt->error;
        exit();
    }
    $stmt->close();
} else {
    echo "Error prepare ibu: " . $conn->error;
    exit();
}

// Update father (ayah) data
$sqlAyah = "UPDATE tk_robbaniy.ayah SET nama = ?, tempat_lahir = ?, tanggal_lahir = ?, nik = ?, agama = ?, pekerjaan = ?, penghasilan = ?, alamat = ?, telepon = ? WHERE id = ?";
if ($stmt = $conn->prepare($sqlAyah)) {
    $stmt->bind_param("ssssssissi", $nama_ayah, $tempat_lahir_ayah, $tanggal_lahir_ayah, $nik_ayah, $agama_ayah, $pekerjaan_ayah, $penghasilan_ayah, $alamat_ayah, $telepon_ayah, $ayah_id);
    if (!$stmt->execute()) {
        echo "Error update ayah: " . $stmt->error;
        exit();
    }
    $stmt->close();
} else {
    echo "Error prepare ayah: " . $conn->error;
    exit();
}

// Update registration (pendaftaran) data
$sqlPendaftaran = "UPDATE tk_robbaniy.pendaftaran SET kode_pendaftaran = ?, murid_id = ?, ayah_id = ?, ibu_id = ?, berkas = ?, user_id = ? WHERE id = ?";
if ($stmt = $conn->prepare($sqlPendaftaran)) {
    $stmt->bind_param("siiisii", $kode_pendaftaran, $murid_id, $ayah_id, $ibu_id, $unique_name, $user_id, $id);
    if ($stmt->execute()) {
        header("Location: index.php?status=success");
        exit();
    } else {
        echo "Error update pendaftaran: " . $stmt->error;
        exit();
    }
    $stmt->close();
} else {
    echo "Error prepare pendaftaran: " . $conn->error;
    exit();
}

$conn->close();
?>