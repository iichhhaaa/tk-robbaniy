<?php
// Start the session
session_start();

// Koneksi ke database
include 'koneksi.php';

// Jika form di-submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Menyiapkan query untuk mencari user berdasarkan username
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username); // Binding parameter
    $stmt->execute();
    $result = $stmt->get_result();

    $sql_settings = "SELECT * FROM settings";
    $stmt_settings = $conn->prepare($sql_settings);
    $stmt_settings->execute();
    $result_settings = $stmt_settings->get_result();

    if ($result->num_rows > 0) {
        // Jika user ditemukan, ambil data user
        $row = $result->fetch_assoc();

        // Verifikasi password
        if (password_verify($password, $row['password'])) {
            // Jika password benar, simpan data di session
            $_SESSION['nama'] = $row['nama']; // Store username in session
            $_SESSION['id'] = $row['id']; // Optionally, store user ID in session
            $_SESSION['role'] = $row['role']; // Menyimpan role user di session

            // Redirect berdasarkan role
            if ($_SESSION['role'] == 'admin') {
                // Jika role adalah admin, redirect ke halaman dashboard admin
                header("Location: view/dashboard/dashboard/index.php");
            } else {
                $row_settings = $result_settings->fetch_assoc();
                if($row_settings['value'] == 'open') {
                // Jika role bukan admin, redirect ke halaman dashboard user biasa
                header("Location: view/dashboard/dashboard-capen/dashboard-user.php");
                } else {
                    $_SESSION['msg_pendaftaran'] = "Pendaftaran sudah ditutup!";
                    header("Location: login.php?err=tutup");
                }
            }
            exit();
        } else {
            // Jika password salah
            $error = "Password salah!";
            header("Location: login.php?error=$error");
            exit();
        }
    } else {
        // Jika username tidak ditemukan
        $error = "Username tidak ditemukan!";
        header("Location: login.php?error=$error");
        exit();
    }
}

// Menutup koneksi
$conn->close();
?>
