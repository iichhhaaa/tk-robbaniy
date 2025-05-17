<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['nama'])) {
    // If not logged in, redirect to login page
    header('Location: ../../../login.php');
    exit();
}

$nama = $_SESSION['nama'];
include '../../../koneksi.php'; // Include the database connection file

// Check if 'id' is passed in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id']; // Get the 'id' parameter from the URL

    // Query to fetch the existing data from the database based on the 'id'
    $sql = "SELECT * FROM pendaftaran WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        // Bind the 'id' parameter
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if record is found
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $kode_pendaftaran = $row['kode_pendaftaran'];
            $berkas = $row['berkas']; // Get the file path (berkas)
        } else {
            // Redirect to the index page if the record is not found
            header("Location: index.php");
            exit();
        }

        $stmt->close();
    }
} else {
    // If 'id' is not passed, redirect to the index page
    header("Location: index.php");
    exit();
}

// Handle the deletion of the file (if exists)
if ($berkas) {
    $file_path = "../../../storage/berkas/" . $berkas;
    if (file_exists($file_path)) {
        unlink($file_path); // Delete the file from the server
    }
}

// Delete the record from the database
$sql_delete = "DELETE FROM pendaftaran WHERE id = ?";
if ($stmt_delete = $conn->prepare($sql_delete)) {
    // Bind the 'id' parameter for deletion
    $stmt_delete->bind_param("i", $id);

    // Execute the query
    if ($stmt_delete->execute()) {
        // Redirect with a success message
        header("Location: index.php?status=success");
        exit();
    } else {
        echo "Error: " . $stmt_delete->error;
    }

    // Close the statement
    $stmt_delete->close();
}

// Close the database connection
$conn->close();
?>
