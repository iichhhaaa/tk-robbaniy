<?php
// Include database connection file
include '../../../koneksi.php'; 

// Ensure that ID is sent via URL
if (isset($_GET['id'])) {
    // Get ID from URL
    $id = $_GET['id'];

    // Query to delete records in pendaftaran table related to user_id
    $sql_delete_pendaftaran = "DELETE FROM pendaftaran WHERE user_id = ?";

    // Prepare query for pendaftaran
    if ($stmt_pendaftaran = $conn->prepare($sql_delete_pendaftaran)) {
        // Bind parameter
        $stmt_pendaftaran->bind_param("i", $id);
        
        // Execute query
        $stmt_pendaftaran->execute();
        $stmt_pendaftaran->close();
    }

    // Query to delete record from users table based on ID
    $sql_delete_user = "DELETE FROM users WHERE id = ?";

    // Prepare query for users
    if ($stmt_user = $conn->prepare($sql_delete_user)) {
        // Bind parameter
        $stmt_user->bind_param("i", $id);

        // Execute query
        if ($stmt_user->execute()) {
            // If deletion successful, redirect to page with success status
            header("Location: index.php?status=success");
        } else {
            header("Location: index.php?status=error");
        }

        // Close statement
        $stmt_user->close();
    }

    // Close connection
    $conn->close();
} else {
    // Display error message in Indonesian for users
    echo "ID tidak ditemukan!";
}
?>