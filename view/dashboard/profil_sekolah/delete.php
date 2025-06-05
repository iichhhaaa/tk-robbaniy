<?php
// Include the database connection file
include '../../../koneksi.php'; 

// Ensure the ID is sent via URL
if (isset($_GET['id'])) {
    // Get the ID from the URL
    $id = $_GET['id'];

    // SQL query to delete data based on ID
    $sql = "DELETE FROM profil_sekolah WHERE id = ?";

    // Prepare the query
    if ($stmt = $conn->prepare($sql)) {
        // Bind parameter
        $stmt->bind_param("i", $id);
        
        // Execute the query
        if ($stmt->execute()) {
            // If delete is successful, redirect with success status
            header("Location: index.php?status=success");
        } else {
            // Redirect with error status if delete fails
            header("Location: index.php?status=error");
        }

        // Close the statement
        $stmt->close();
    }

    // Close the database connection
    $conn->close();
} else {
    // Display message if ID not found
    echo "ID tidak ditemukan!";
}
?>