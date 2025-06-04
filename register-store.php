<?php
session_start();
include 'koneksi.php'; // Ensure the database connection is correct

// Check registration status
$check_registration_query = "SELECT * FROM settings WHERE key_name = 'pendaftaran_status' LIMIT 1";
$result_settings = $conn->query($check_registration_query);

$status_pendaftaran = 'open'; // Default registration status is open
if ($result_settings && $result_settings->num_rows > 0) {
    $row_settings = $result_settings->fetch_assoc();
    $status_pendaftaran = $row_settings['value'];
}

// If registration is closed, display message and stop registration process
if ($status_pendaftaran == 'closed') {
    $_SESSION['msg_pendaftaran'] = "Pendaftaran sudah ditutup!"; // Message visible to user in Indonesian
    header("Location: register.php"); // Redirect to registration page
    exit();
}

// If the form is submitted via POST method
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $nama = $_POST['nama'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $username = $_POST['username'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Input validation
    $errors = [];

    if (empty($nama)) {
        $errors[] = "Nama wajib diisi."; // User-facing message in Indonesian
    }

    if (empty($username)) {
        $errors[] = "Nama pengguna wajib diisi."; // User-facing message in Indonesian
    }

    if (empty($email)) {
        $errors[] = "Alamat email wajib diisi."; // User-facing message in Indonesian
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Silakan masukkan alamat email yang valid."; // User-facing message in Indonesian
    }

    if (empty($password)) {
        $errors[] = "Kata sandi wajib diisi."; // User-facing message in Indonesian
    }

    if ($password !== $confirm_password) {
        $errors[] = "Kata sandi tidak cocok."; // User-facing message in Indonesian
    }

    // If no validation errors
    if (empty($errors)) {
        // Hash the password securely
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $role = 'capen'; // Set default user role

        // Check if email or username already exists
        $check_email_query = "SELECT * FROM users WHERE email = ? OR username = ?";
        $stmt = $conn->prepare($check_email_query);
        $stmt->bind_param("ss", $email, $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $errors[] = "Alamat email atau nama pengguna ini sudah terdaftar."; // User-facing message in Indonesian
        } else {
            // Insert new user data into users table
            $insert_query = "INSERT INTO users (username, password, role, nama, email) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($insert_query);
            $stmt->bind_param("sssss", $username, $hashed_password, $role, $nama, $email);

            if ($stmt->execute()) {
                $_SESSION['message'] = "Daftar Akun Berhasil. Silahkan Masuk!"; // User-facing message in Indonesian
                header("Location: register.php"); // Redirect after successful registration
                exit();
            } else {
                $errors[] = "Terjadi kesalahan saat mendaftar. Silakan coba lagi."; // User-facing message in Indonesian
            }
        }
    }

    // If there are errors, save them to session and redirect back to registration page
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: register.php");
        exit();
    }
} else {
    // Redirect if accessed directly without POST
    header("Location: register.php");
    exit();
}