<?php
// Include database connection file
include '../../../koneksi.php'; 

// Ensure ID is passed via URL
if (isset($_GET['id'])) {
    // Get ID from URL
    $id = $_GET['id'];

    // SQL query to delete data by ID
    $sql = "DELETE FROM keunggulan WHERE id = ?";

    // Prepare statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind parameter
        $stmt->bind_param("i", $id);
        
        // Execute query
        if ($stmt->execute()) {
            // Redirect to index with success status if delete is successful
            header("Location: index.php?status=success");
        } else {
            // Redirect to index with error status if delete fails
            header("Location: index.php?status=error");
        }

        // Close statement
        $stmt->close();
    }

    // Close connection
    $conn->close();
} else {
    // Display message if ID is not found
    echo "ID tidak ditemukan!";
}
?>