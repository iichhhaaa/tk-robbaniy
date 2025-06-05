<?php
// Include the database connection file
include '../../../koneksi.php'; 

// Ensure that an ID is provided via the URL
if (isset($_GET['id'])) {
    // Retrieve the ID from the URL
    $id = $_GET['id'];

    // SQL query to delete the record based on the ID
    $sql = "DELETE FROM berita WHERE id = ?";

    // Prepare the SQL statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind the parameter to the statement
        $stmt->bind_param("i", $id);
        
        // Execute the query
        if ($stmt->execute()) {
            // If deletion is successful, redirect to index page with success message
            header("Location: index.php?status=success");
        } else {
            // Redirect to index page with error status if execution fails
            header("Location: index.php?status=error");
        }

        // Close the statement
        $stmt->close();
    }

    // Close the database connection
    $conn->close();
} else {
    // Display an error message if ID is not found
    echo "ID tidak ditemukan!";
}
?>