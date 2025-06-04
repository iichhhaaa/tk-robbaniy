<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<div class='alert alert-danger'>Alamat email tidak valid!</div>";
    } else {
        // Include database connection
        include 'koneksi.php';

        // Prepare SQL query to check if email exists in users table
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if email was found
        if ($result->num_rows > 0) {
            // Email found, notify user that reset link has been sent
            echo "<div class='alert alert-success'>Tautan untuk mengatur ulang kata sandi telah dikirim ke alamat email Anda.</div>";
        } else {
            // Email not found, advise user to contact admin
            echo "<div class='alert alert-warning'>Email tidak ditemukan. Silakan hubungi admin melalui <a href='mailto:admin@robbaniy.com'>admin@robbaniy.com</a> untuk bantuan lebih lanjut.</div>";
        }

        // Close database connection
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Beranda</title>
  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
  <!-- Fonts & Custom CSS -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="assets/css/style.css">
</head>

<body style="background-color: #2f4f1f;"> <!-- Set background color -->

    <div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh;">
        <div class="row justify-content-center w-100">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <!-- Page heading -->
                                        <h1 class="h4 text-gray-900 mb-4">Lupa Kata Sandi Anda?</h1>
                                    </div>
                                    <!-- Forgot password form -->
                                    <form class="user" method="POST" action="forgot-password.php">
                                        <div class="form-group">
                                            <!-- Email input field -->
                                            <input type="email" class="form-control form-control-user" id="exampleInputEmail" placeholder="Enter your email" name="email" required>
                                        </div>
                                        <!-- Submit button -->
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Send Reset Link
                                        </button>
                                    </form>

                                    <hr>
                                    <div class="text-center">
                                        <!-- Link back to login page -->
                                        <a href="login.php" class="small">Back to Login</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>