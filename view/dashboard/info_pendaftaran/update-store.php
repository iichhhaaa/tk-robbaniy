<?php
include '../../../koneksi.php'; // Include the database connection file

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $id = $_POST['id'];
    $syarat = $_POST['syarat_pendaftaran'];
    $info = $_POST['biaya_ppdb'];

    // Fetch the existing record to check for the old data (for example, the existing photo)
    $sql_fetch = "SELECT * FROM info_pendaftaran WHERE id = ?";
    if ($stmt_fetch = $conn->prepare($sql_fetch)) {
        $stmt_fetch->bind_param("i", $id);
        $stmt_fetch->execute();
        $result_fetch = $stmt_fetch->get_result();

        // If record exists, fetch the current data
        if ($result_fetch->num_rows > 0) {
            $row = $result_fetch->fetch_assoc();
            // If you need to handle the existing photo or other fields, do so here
        } else {
            // Data tidak ditemukan, hentikan proses
            echo "Data tidak ditemukan!";
            exit();
        }
        $stmt_fetch->close();
    }

    // Prepare an SQL query to update the data in the database
    $sql_update = "UPDATE info_pendaftaran SET syarat_pendaftaran = ?, biaya_ppdb = ? WHERE id = ?";

    if ($stmt_update = $conn->prepare($sql_update)) {
        // Bind the parameters for updating
        $stmt_update->bind_param("ssi", $syarat, $info, $id);

        // Execute the query
        if ($stmt_update->execute()) {
            // Redirect to the success page or show a success message
            header("Location: update.php?id=$id&status=success");
        } else {
            // Tampilkan pesan kesalahan jika gagal mengupdate
            echo "Terjadi kesalahan: " . $stmt_update->error;
        }

        // Close the statement
        $stmt_update->close();
    }

    // Close the database connection
    $conn->close();
}
?>