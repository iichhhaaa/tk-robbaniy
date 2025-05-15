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
    exit(); // Hentikan eksekusi lebih lanjut
}

// Jika form di-submit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $username = $_POST['username'];
    $confirm_password = $_POST['confirm_password'];

    // Validate form data
    $errors = [];

    if (empty($nama)) {
        $errors[] = "Nama wajib Diisi.";
    }

    if (empty($username)) {
        $errors[] = "Username wajib Diisi.";
    }

    if (empty($email)) {
        $errors[] = "Alamat email wajib diisi.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Silakan masukkan alamat email yang valid.";
    }

    if (empty($password)) {
        $errors[] = "Kata Sandi wajib diisi";
    }

    if ($password !== $confirm_password) {
        $errors[] = "Kata sandi tidak cocok.";
    }

    // If there are no validation errors
    if (empty($errors)) {
        // Hash the password for security
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $role = 'capen';

        // Check if email or username already exists
        $check_email_query = "SELECT * FROM users WHERE email = ? OR username = ?";
        $stmt = $conn->prepare($check_email_query);
        $stmt->bind_param("ss", $email, $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Email or username already exists
            $errors[] = "Email atau username ini sudah terdaftar.";
        } else {
            // Insert the new user into the database
            $insert_query = "INSERT INTO users (username, password, role, nama, email) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($insert_query);
            $stmt->bind_param("sssss", $username, $hashed_password, $role, $nama, $email);

            if ($stmt->execute()) {
                // Registration successful, redirect to login page
                $_SESSION['message'] = "Daftar Akun Berhasil. Silahkan Login!";
                header("Location: register.php");
                exit();
            } else {
                // Error inserting user into database
                $errors[] = "Terjadi kesalahan saat mendaftar. Silakan coba lagi.";
            }
        }
    }
}
?>

<!-- Display errors if any -->
<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?php echo $error; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
