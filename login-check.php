<?php
session_start();
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get username and password from POST request, set empty string if not provided
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Prepare SQL query to find user by username
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User found, fetch user data
        $row = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $row['password'])) {
            // Store user data in session
            $_SESSION['nama'] = $row['nama'];
            $_SESSION['id'] = $row['id'];
            $_SESSION['role'] = $row['role'];

            // Redirect user based on their role
            if ($_SESSION['role'] == 'admin') {
                header("Location: view/dashboard/dashboard/index.php");
            } else {
                header("Location: view/dashboard/dashboard-capen/dashboard-user.php");
            }
            exit();
        } else {
            // Incorrect password
            $error = "Kata sandi salah!"; // Visible to user in Indonesian
            header("Location: login.php?error=" . urlencode($error));
            exit();
        }
    } else {
        // Username not found
        $error = "Nama pengguna tidak ditemukan!"; // Visible to user in Indonesian
        header("Location: login.php?error=" . urlencode($error));
        exit();
    }
}

// Close database connection
$conn->close();
?>