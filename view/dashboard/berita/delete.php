<?php
// Include file koneksi
include '../../../koneksi.php'; 

// Memastikan bahwa ID dikirimkan melalui URL
if (isset($_GET['id'])) {
    // Mengambil ID dari URL
    $id = $_GET['id'];

    // Query untuk menghapus data berdasarkan ID
    $sql = "DELETE FROM berita WHERE id = ?";

    // Persiapkan query
    if ($stmt = $conn->prepare($sql)) {
        // Bind parameter
        $stmt->bind_param("i", $id);
        
        // Eksekusi query
        if ($stmt->execute()) {
            // Jika berhasil menghapus, arahkan ke halaman yang sesuai dengan query string sukses
            header("Location: index.php?status=success");
        } else {
            header("Location: index.php?status=error");
        }

        // Tutup statement
        $stmt->close();
    }

    // Tutup koneksi
    $conn->close();
} else {
    echo "ID tidak ditemukan!";
}
?>