<?php
include '../../../koneksi.php'; // Include the database connection file

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $username = $_POST['username'];
    $password = $_POST['password']; // New password
    $role = $_POST['role'];
    $nama = $_POST['nama'];
    $email = $_POST['email'];

    // Hash the password before storing it in the database
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare an SQL query to insert the data into the database
    $sql = "INSERT INTO users (username, password, role, nama, email) VALUES (?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        // Bind the parameters
        $stmt->bind_param("sssss", $username, $hashed_password, $role, $nama, $email);

        // Execute the query
        if ($stmt->execute()) {
            // Redirect to create.php with status=success
            header("Location: create.php?status=success");
            exit();
        } else {
            // Display error message in Indonesian for users
            echo "Terjadi kesalahan: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    }

    // Close the database connection
    $conn->close();
}
?>