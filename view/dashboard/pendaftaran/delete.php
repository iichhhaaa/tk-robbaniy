<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['nama'])) {
    // Jika belum login, redirect ke halaman login
    header('Location: ../../../login.php');
    exit();
}

$nama = $_SESSION['nama'];
include '../../../koneksi.php'; // Sertakan file koneksi database

// Cek apakah 'id' ada di URL
if (isset($_GET['id'])) {
    $id = $_GET['id']; // Ambil parameter 'id' dari URL

    // Query untuk mengambil data berdasarkan 'id'
    $sql = "SELECT * FROM pendaftaran WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        // Bind parameter 'id'
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Cek apakah record ditemukan
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $kode_pendaftaran = $row['kode_pendaftaran'];
            $berkas = $row['berkas']; // Ambil path berkas
        } else {
            // Redirect ke halaman index jika record tidak ditemukan
            header("Location: index.php");
            exit();
        }

        $stmt->close();
    } else {
        // Jika query gagal, redirect ke halaman index
        header("Location: index.php?status=error_query");
        exit();
    }
} else {
    // Jika 'id' tidak ada, redirect ke halaman index
    header("Location: index.php");
    exit();
}

// Hapus berkas yang terkait (jika ada)
if ($berkas) {
    $file_path = "../../../storage/berkas/" . $berkas;
    if (file_exists($file_path)) {
        // Hapus file dari server
        if (!unlink($file_path)) {
            // Jika gagal menghapus file, beri pesan error
            header("Location: index.php?status=error_delete_file");
            exit();
        }
    }
}

// Hapus record dari database
$sql_delete = "DELETE FROM pendaftaran WHERE id = ?";
if ($stmt_delete = $conn->prepare($sql_delete)) {
    // Bind parameter 'id' untuk penghapusan
    $stmt_delete->bind_param("i", $id);

    // Eksekusi query
    if ($stmt_delete->execute()) {
        // Redirect ke halaman index dengan status sukses
        header("Location: index.php?status=success");
        exit();
    } else {
        // Jika query penghapusan gagal, beri pesan error
        echo "Error: " . $stmt_delete->error;
        exit();
    }

    // Tutup statement
    $stmt_delete->close();
} else {
    // Jika query penghapusan gagal, beri pesan error
    echo "Error: " . $conn->error;
    exit();
}

// Tutup koneksi database
$conn->close();
?>
