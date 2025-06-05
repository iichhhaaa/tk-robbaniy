<?php
// Include the database connection file
include '../../../koneksi.php'; 

// Ensure the ID is sent via URL
if (isset($_GET['id'])) {
    // Retrieve ID from URL
    $id = $_GET['id'];

    // SQL query to delete data by ID
    $sql = "DELETE FROM fasilitas WHERE id = ?";

    // Prepare the query
    if ($stmt = $conn->prepare($sql)) {
        // Bind the parameter
        $stmt->bind_param("i", $id);
        
        // Execute the query
        if ($stmt->execute()) {
            // If deletion successful, redirect to index with success status
            header("Location: index.php?status=success");
        } else {
            // Redirect with error status on failure
            header("Location: index.php?status=error");
        }

        // Close the statement
        $stmt->close();
    }

    // Close the database connection
    $conn->close();
} else {
    // Show message if ID is not found
    echo "ID tidak ditemukan!";
}
?>