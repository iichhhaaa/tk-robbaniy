<?php
session_start();
include 'koneksi.php'; // Pastikan koneksi ke database sudah benar

// Cek status pendaftaran
$check_registration_query = "SELECT * FROM settings WHERE key_name = 'pendaftaran_status' LIMIT 1";
$result_settings = $conn->query($check_registration_query);

$status_pendaftaran = 'open'; // Default pendaftaran dibuka
if ($result_settings && $result_settings->num_rows > 0) {
    $row_settings = $result_settings->fetch_assoc();
    $status_pendaftaran = $row_settings['value'];
}

// Jika pendaftaran ditutup, tampilkan pesan dan hentikan proses registrasi
if ($status_pendaftaran == 'closed') {
    $_SESSION['msg_pendaftaran'] = "Pendaftaran sudah ditutup!";
    header("Location: register.php"); // Redirect ke halaman register.php
    exit();
}

// Jika form di-submit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data form
    $nama = $_POST['nama'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $username = $_POST['username'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Validasi input
    $errors = [];

    if (empty($nama)) {
        $errors[] = "Nama wajib diisi.";
    }

    if (empty($username)) {
        $errors[] = "Nama pengguna wajib diisi.";
    }

    if (empty($email)) {
        $errors[] = "Alamat email wajib diisi.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Silakan masukkan alamat email yang valid.";
    }

    if (empty($password)) {
        $errors[] = "Kata sandi wajib diisi.";
    }

    if ($password !== $confirm_password) {
        $errors[] = "Kata sandi tidak cocok.";
    }

    // Jika tidak ada error validasi
    if (empty($errors)) {
        // Hash password
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $role = 'capen';

        // Cek email atau username sudah ada?
        $check_email_query = "SELECT * FROM users WHERE email = ? OR username = ?";
        $stmt = $conn->prepare($check_email_query);
        $stmt->bind_param("ss", $email, $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $errors[] = "Alamat email atau nama pengguna ini sudah terdaftar.";
        } else {
            // Insert user baru
            $insert_query = "INSERT INTO users (username, password, role, nama, email) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($insert_query);
            $stmt->bind_param("sssss", $username, $hashed_password, $role, $nama, $email);

            if ($stmt->execute()) {
                $_SESSION['message'] = "Daftar Akun Berhasil. Silahkan Masuk!";
                header("Location: register.php");
                exit();
            } else {
                $errors[] = "Terjadi kesalahan saat mendaftar. Silakan coba lagi.";
            }
        }
    }

    // Jika ada error, simpan ke session dan redirect ke register.php
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: register.php");
        exit();
    }
} else {
    // Jika akses langsung tanpa POST
    header("Location: register.php");
    exit();
}
