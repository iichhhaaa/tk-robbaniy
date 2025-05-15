<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Validasi email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<div class='alert alert-danger'>Invalid email address!</div>";
    } else {
        // Cek apakah email ada di database
        include 'koneksi.php';
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Email ditemukan, informasikan ke pengguna bahwa email reset dikirim
            echo "<div class='alert alert-success'>An email with reset instructions has been sent to your email address.</div>";
        } else {
            // Jika email tidak ditemukan, beri tahu pengguna untuk menghubungi admin
            echo "<div class='alert alert-warning'>Email not found. Please contact support at <a href='mailto:admin@robbaniy.com'>admin@robbaniy.com</a> for assistance.</div>";
        }

        // Menutup koneksi
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Forgot Password</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background-color: #2f4f1f;"> <!-- Background color -->

    <div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh;">
        <div class="row justify-content-center w-100">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Forgot Your Password?</h1>
                                    </div>
                                    <form class="user" method="POST" action="forgot-password.php">
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user" id="exampleInputEmail" placeholder="Enter your email" name="email" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Send Reset Link
                                        </button>
                                    </form>

                                    <hr>
                                    <div class="text-center">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
