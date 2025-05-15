<?php
// Include file koneksi
include '../../../koneksi.php'; 

// Memastikan bahwa ID dikirimkan melalui URL
if (isset($_GET['id'])) {
    // Mengambil ID dari URL
    $id = $_GET['id'];

    // Query untuk menghapus data di tabel pendaftaran yang terkait dengan user_id
    $sql_delete_pendaftaran = "DELETE FROM pendaftaran WHERE user_id = ?";

    // Persiapkan query untuk pendaftaran
    if ($stmt_pendaftaran = $conn->prepare($sql_delete_pendaftaran)) {
        // Bind parameter
        $stmt_pendaftaran->bind_param("i", $id);
        
        // Eksekusi query
        $stmt_pendaftaran->execute();
        $stmt_pendaftaran->close();
    }

    // Query untuk menghapus data dari tabel users berdasarkan ID
    $sql_delete_user = "DELETE FROM users WHERE id = ?";

    // Persiapkan query untuk users
    if ($stmt_user = $conn->prepare($sql_delete_user)) {
        // Bind parameter
        $stmt_user->bind_param("i", $id);

        // Eksekusi query
        if ($stmt_user->execute()) {
            // Jika berhasil menghapus, arahkan ke halaman yang sesuai dengan query string sukses
            header("Location: index.php?status=success");
        } else {
            header("Location: index.php?status=error");
        }

        // Tutup statement
        $stmt_user->close();
    }

    // Tutup koneksi
    $conn->close();
} else {
    echo "ID tidak ditemukan!";
}
?>
