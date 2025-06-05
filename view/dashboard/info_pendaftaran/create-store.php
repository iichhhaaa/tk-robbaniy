<?php
include '../../../koneksi.php'; // Connect to the database

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form input
    $syarat_pendaftaran = $_POST['syarat_pendaftaran'];
    $biaya_ppdb = $_POST['biaya_ppdb'];

    // Prepare the target directory for uploaded image
    $target_dir = "../../../storage/info_pendaftaran/";

    if (isset($_FILES['foto']) && $_FILES['foto']['name'] != '') {
        // Generate a unique file name using uniqid and random number
        $file_extension = strtolower(pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION));
        $unique_name = uniqid('pendaftaran', true) . rand(1000, 9999) . '.' . $file_extension;
        $target_file = $target_dir . $unique_name;

        $uploadOk = 1;

        // Check if the uploaded file is an actual image
        if (isset($_POST["submit"])) {
            $check = getimagesize($_FILES["foto"]["tmp_name"]);
            if ($check !== false) {
                $uploadOk = 1;
            } else {
                echo "File bukan gambar yang valid.";
                $uploadOk = 0;
            }
        }

        // Check if the file already exists (though name is unique)
        if (file_exists($target_file)) {
            echo "Maaf, file sudah ada.";
            $uploadOk = 0;
        }

        // Limit the size to 5MB
        if ($_FILES["foto"]["size"] > 5000000) {
            echo "Maaf, ukuran file terlalu besar (maksimal 5MB).";
            $uploadOk = 0;
        }

        // Allow only specific file types
        if ($file_extension != "jpg" && $file_extension != "png" && $file_extension != "jpeg") {
            echo "Maaf, hanya file JPG, JPEG & PNG yang diperbolehkan.";
            $uploadOk = 0;
        }

        // Try to upload if all checks pass
        if ($uploadOk == 1) {
            if (!move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
                echo "Maaf, terjadi kesalahan saat mengunggah file.";
                $uploadOk = 0;
            }
        }
    } else {
        // No photo uploaded
        $unique_name = '';
    }

    // Insert data into the database
    $sql = "INSERT INTO info_pendaftaran (syarat_pendaftaran, biaya_ppdb) VALUES (?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        // Bind the parameters
        $stmt->bind_param("ss", $syarat_pendaftaran, $biaya_ppdb);

        // Execute the query
        if ($stmt->execute()) {
            // Redirect to success message
            header("Location: create.php?status=success");
            exit();
        } else {
            echo "Terjadi kesalahan: " . $stmt->error;
        }

        // Close statement
        $stmt->close();
    }
}

// Close DB connection
$conn->close();
?>