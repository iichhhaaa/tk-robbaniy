<?php
// Include the database connection file
include '../../../koneksi.php'; 

// Ensure the ID is sent via URL
if (isset($_GET['id'])) {
    // Get the ID from the URL
    $id = $_GET['id'];

    // Query to delete the record based on ID
    $sql = "DELETE FROM info_pendaftaran WHERE id = ?";

    // Prepare the query
    if ($stmt = $conn->prepare($sql)) {
        // Bind the parameter
        $stmt->bind_param("i", $id);
        
        // Execute the query
        if ($stmt->execute()) {
            // If deletion is successful, redirect with a success status
            header("Location: index.php?status=success");
        } else {
            // Redirect with error status if deletion fails
            header("Location: index.php?status=error");
        }

        // Close the statement
        $stmt->close();
    }

    // Close the connection
    $conn->close();
} else {
    echo "ID tidak ditemukan!";
}
?>