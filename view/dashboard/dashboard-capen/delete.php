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
        if (!$stmt->execute()) {
            echo "Error executing query: " . $stmt->error;
            $stmt->close();
            $conn->close();
            exit();
        }
        $result = $stmt->get_result();

        // Check if record is found
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $kode_pendaftaran = $row['kode_pendaftaran'];
            $berkas = $row['berkas']; // Get the file path (berkas)
            $murid_id = $row['murid_id'];
            $ayah_id = $row['ayah_id'];
            $ibu_id = $row['ibu_id'];
        } else {
            // Redirect to the index page if the record is not found
            $stmt->close();
            $conn->close();
            header("Location: index.php");
            exit();
        }

        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
        $conn->close();
        exit();
    }
} else {
    // If 'id' is not passed, redirect to the index page
    header("Location: index.php");
    exit();
}

// Begin transaction to ensure all deletions succeed or fail together
$conn->begin_transaction();

try {
    // Delete related murid record
    $sql_delete_murid = "DELETE FROM murid WHERE id = ?";
    if ($stmt_murid = $conn->prepare($sql_delete_murid)) {
        $stmt_murid->bind_param("i", $murid_id);
        if (!$stmt_murid->execute()) {
            throw new Exception("Error deleting murid: " . $stmt_murid->error);
        }
        $stmt_murid->close();
    } else {
        throw new Exception("Error preparing murid delete statement: " . $conn->error);
    }

    // Delete related ayah record
    $sql_delete_ayah = "DELETE FROM ayah WHERE id = ?";
    if ($stmt_ayah = $conn->prepare($sql_delete_ayah)) {
        $stmt_ayah->bind_param("i", $ayah_id);
        if (!$stmt_ayah->execute()) {
            throw new Exception("Error deleting ayah: " . $stmt_ayah->error);
        }
        $stmt_ayah->close();
    } else {
        throw new Exception("Error preparing ayah delete statement: " . $conn->error);
    }

    // Delete related ibu record
    $sql_delete_ibu = "DELETE FROM ibu WHERE id = ?";
    if ($stmt_ibu = $conn->prepare($sql_delete_ibu)) {
        $stmt_ibu->bind_param("i", $ibu_id);
        if (!$stmt_ibu->execute()) {
            throw new Exception("Error deleting ibu: " . $stmt_ibu->error);
        }
        $stmt_ibu->close();
    } else {
        throw new Exception("Error preparing ibu delete statement: " . $conn->error);
    }

    // Handle the deletion of the file (if exists)
    if ($berkas) {
        $file_path = "../../../storage/berkas/" . $berkas;
        if (file_exists($file_path)) {
            if (!unlink($file_path)) {
                throw new Exception("Failed to delete file: " . $file_path);
            }
        }
    }

    // Delete the pendaftaran record last
    $sql_delete_pendaftaran = "DELETE FROM pendaftaran WHERE id = ?";
    if ($stmt_pendaftaran = $conn->prepare($sql_delete_pendaftaran)) {
        $stmt_pendaftaran->bind_param("i", $id);
        if (!$stmt_pendaftaran->execute()) {
            throw new Exception("Error deleting pendaftaran: " . $stmt_pendaftaran->error);
        }
        $stmt_pendaftaran->close();
    } else {
        throw new Exception("Error preparing pendaftaran delete statement: " . $conn->error);
    }

    // Commit transaction
    $conn->commit();

    // Redirect with a success message
    header("Location: index.php?status=success");
    exit();

} catch (Exception $e) {
    // Rollback transaction on error
    $conn->rollback();
    echo "Transaction failed: " . $e->getMessage();
}

// Close the database connection
$conn->close();
?>
