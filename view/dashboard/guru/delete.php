<?php
// Include the database connection file
include '../../../koneksi.php'; 

// Ensure that ID is sent through the URL
if (isset($_GET['id'])) {
    // Get the ID from the URL
    $id = $_GET['id'];

    // SQL query to delete data based on ID
    $sql = "DELETE FROM guru WHERE id = ?";

    // Prepare the query
    if ($stmt = $conn->prepare($sql)) {
        // Bind the parameter
        $stmt->bind_param("i", $id);
        
        // Execute the query
        if ($stmt->execute()) {
            // If deletion is successful, redirect with a success status
            header("Location: index.php?status=success");
        } else {
            // Redirect with an error status if execution fails
            header("Location: index.php?status=error");
        }

        // Close the statement
        $stmt->close();
    }

    // Close the connection
    $conn->close();
} else {
    // Display error message if ID is not found
    echo "ID tidak ditemukan!";
}
?>