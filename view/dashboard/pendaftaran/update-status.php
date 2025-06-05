<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['nama'])) {
    // If not logged in, redirect to login page
    header('Location: ../../../login.php');
    exit();
}

if ($_SESSION['role'] !== 'admin') {
    // If user is not admin, redirect to user dashboard
    header('Location: ../dashboard-capen/index.php');
    exit();
}

// Check if POST data for pendaftaran_status is set
if (isset($_POST['pendaftaran_status'])) {
    // Get the new status (either 'open' or 'closed')
    $new_status = $_POST['pendaftaran_status'];

    // Include the database connection file
    include '../../../koneksi.php';

    // Prepare SQL query to update pendaftaran_status in settings table
    $sql = "UPDATE settings SET value = ? WHERE key_name = 'pendaftaran_status'";

    // Prepare the SQL statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind the new status parameter
        $stmt->bind_param("s", $new_status);

        // Execute the update query
        if ($stmt->execute()) {
            // Success: display success message in Indonesian
            echo "Status berhasil diperbarui!";
        } else {
            // Failure: display error message in Indonesian
            echo "Terjadi kesalahan saat memperbarui status.";
        }

        // Close the statement
        $stmt->close();
    } else {
        // Query preparation error message
        echo "Terjadi kesalahan saat menyiapkan query.";
    }

    // Close the database connection
    $conn->close();
} else {
    // If pendaftaran_status not found in POST data
    echo "Status tidak ditemukan.";
}
?>

<?php
// Include database connection
include '../../../koneksi.php';

// Get pendaftaran ID and new status from POST data
$pendaftaran_id = $_POST['pendaftaran_id'];
$new_status = $_POST['pendaftaran_status'];

// Prepare SQL query to update status in pendaftaran table
$sql = "UPDATE pendaftaran SET status = ? WHERE id = ?";

if ($stmt = $conn->prepare($sql)) {
    // Bind parameters: status (string) and id (integer)
    $stmt->bind_param("si", $new_status, $pendaftaran_id);

    // Execute the update query
    if ($stmt->execute()) {
        // Success message in Indonesian
        echo "Status berhasil diperbarui!";
    } else {
        // Display error message with statement error in Indonesian
        echo "Terjadi kesalahan: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
} else {
    // Display error message with connection error in Indonesian
    echo "Terjadi kesalahan: " . $conn->error;
}

// Close the database connection
$conn->close();
?>