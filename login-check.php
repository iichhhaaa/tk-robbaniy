<?php
session_start();
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Cari user berdasarkan username
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verifikasi password
        if (password_verify($password, $row['password'])) {
            // Simpan data session
            $_SESSION['nama'] = $row['nama'];
            $_SESSION['id'] = $row['id'];
            $_SESSION['role'] = $row['role'];

            // Redirect sesuai role
            if ($_SESSION['role'] == 'admin') {
                header("Location: view/dashboard/dashboard/index.php");
            } else {
                header("Location: view/dashboard/dashboard-capen/dashboard-user.php");
            }
            exit();
        } else {
            // Password salah
            $error = "Kata sandi salah!";
            header("Location: login.php?error=" . urlencode($error));
            exit();
        }
    } else {
        // Username tidak ditemukan
        $error = "Nama pengguna tidak ditemukan!";
        header("Location: login.php?error=" . urlencode($error));
        exit();
    }
}

$conn->close();
?>
