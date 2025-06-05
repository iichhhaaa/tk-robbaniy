<?php
include '../../../koneksi.php'; // Include the database connection file

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $id = $_POST['id'];
    $username = $_POST['username'];
    $password = $_POST['password']; // New password
    $role = $_POST['role'];
    $nama = $_POST['nama'];
    $email = $_POST['email'];

    // Fetch the existing record to check if we need to update the password
    $sql_fetch = "SELECT password FROM users WHERE id = ?";
    if ($stmt_fetch = $conn->prepare($sql_fetch)) {
        $stmt_fetch->bind_param("i", $id);
        $stmt_fetch->execute();
        $result_fetch = $stmt_fetch->get_result();

        // If record exists, fetch the current password
        if ($result_fetch->num_rows > 0) {
            $row = $result_fetch->fetch_assoc();
            $old_password = $row['password']; // The existing password
        } else {
            echo "Data tidak ditemukan!";
            exit();
        }
        $stmt_fetch->close();
    }

    // Check if the password is being updated
    if (!empty($password)) {
        // If password is provided, hash the new password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    } else {
        // If no new password is provided, keep the old password
        $hashed_password = $old_password;
    }

    // Prepare an SQL query to update the data in the database
    $sql_update = "UPDATE users SET username = ?, password = ?, role = ?, nama = ?, email = ? WHERE id = ?";

    if ($stmt_update = $conn->prepare($sql_update)) {
        // Bind the parameters
        $stmt_update->bind_param("sssssi", $username, $hashed_password, $role, $nama, $email, $id);

        // Execute the query
        if ($stmt_update->execute()) {
            // Redirect to the success page or show a success message
            header("Location: update.php?id=$id&status=success");
        } else {
            echo "Terjadi kesalahan: " . $stmt_update->error;
        }

        // Close the statement
        $stmt_update->close();
    }

    // Close the database connection
    $conn->close();
}
?>