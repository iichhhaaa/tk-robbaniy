<?php
// Include the database connection file
include '../../../koneksi.php'; 

// Ensure that the ID is sent via URL
if (isset($_GET['id'])) {
    // Get the ID from the URL
    $id = $_GET['id'];

    // SQL query to delete data based on the ID
    $sql = "DELETE FROM galeri WHERE id = ?";

    // Prepare the query
    if ($stmt = $conn->prepare($sql)) {
        // Bind the parameter
        $stmt->bind_param("i", $id);
        
        // Execute the query
        if ($stmt->execute()) {
            // If successfully deleted, redirect to the page with success status
            header("Location: index.php?status=success");
        } else {
            // Redirect with error status if deletion failed
            header("Location: index.php?status=error");
        }

        // Close the statement
        $stmt->close();
    }

    // Close the connection
    $conn->close();
} else {
    // Show message if ID is not found
    echo "ID tidak ditemukan!";
}
?>