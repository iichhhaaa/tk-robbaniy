<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['nama'])) {
    // If not logged in, redirect to login page
    header('Location: ../../../login.php');
    exit();
}

// Check if the POST data is set
if (isset($_POST['pendaftaran_status'])) {
    // Get the new status (either 'open' or 'closed')
    $new_status = $_POST['pendaftaran_status'];

    // Include the database connection
    include '../../../koneksi.php';

    // Update the status in the database
    $sql = "UPDATE settings SET value = ? WHERE key_name = 'pendaftaran_status'";

    // Prepare the SQL statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind the parameters (new status)
        $stmt->bind_param("s", $new_status);

        // Execute the query
        if ($stmt->execute()) {
            // Success: Return success message
            echo "Status berhasil diperbarui!";
        } else {
            // Error: Return failure message
            echo "Terjadi kesalahan saat memperbarui status.";
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        echo "Terjadi kesalahan saat menyiapkan query.";
    }

    // Close the database connection
    $conn->close();
} else {
    echo "Status tidak ditemukan.";
}
?>

<?php
include '../../../koneksi.php';

// Get the pendaftaran ID and the new status
$pendaftaran_id = $_POST['pendaftaran_id'];
$new_status = $_POST['pendaftaran_status'];

// Update the status in the pendaftaran table
$sql = "UPDATE pendaftaran SET status = ? WHERE id = ?";

if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("si", $new_status, $pendaftaran_id);
    if ($stmt->execute()) {
        echo "Status berhasil diperbarui!";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
