<?php
include '../../../koneksi.php'; // Include the database connection file

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $judul = $_POST['judul'];
    $content = $_POST['content'];
    $created_at = $_POST['created_at'];

    // Handle file upload for 'foto'
    $target_dir = "../../../storage/berita/"; // Directory to store the uploaded image
    
    // Generate a unique file name using uniqid() and rand()
    $file_extension = strtolower(pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION));
    $unique_name = uniqid('berita', true) . rand(1000, 9999) . '.' . $file_extension;
    $target_file = $target_dir . $unique_name; // The full path where the file will be stored

    $uploadOk = 1;

    // Validate uploaded file is an image
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["foto"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File bukan gambar yang valid.";
            $uploadOk = 0;
        }
    }

    // Double-check if the file somehow already exists
    if (file_exists($target_file)) {
        echo "Maaf, file sudah ada.";
        $uploadOk = 0;
    }

    // Check maximum file size (5MB)
    if ($_FILES["foto"]["size"] > 5000000) {
        echo "Maaf, ukuran file terlalu besar. Maksimal 5MB.";
        $uploadOk = 0;
    }

    // Allow only certain image file extensions
    if ($file_extension != "jpg" && $file_extension != "png" && $file_extension != "jpeg" && $file_extension != "gif") {
        echo "Maaf, hanya file JPG, JPEG, PNG, dan GIF yang diperbolehkan.";
        $uploadOk = 0;
    }

    // If any validation fails, cancel the upload
    if ($uploadOk == 0) {
        echo "Maaf, file tidak berhasil diunggah.";
    } else {
        // Attempt to upload the image
        if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
            // Insert the form data and image name into the database
            $sql = "INSERT INTO berita (judul, content, foto, created_at) VALUES (?, ?, ?, ?)";

            if ($stmt = $conn->prepare($sql)) {
                // Bind parameters to the prepared statement
                $stmt->bind_param("ssss", $judul, $content, $unique_name, $created_at);

                // Execute the statement
                if ($stmt->execute()) {
                    // Redirect to success page
                    header("Location: create.php?status=success");
                    exit();
                } else {
                    echo "Terjadi kesalahan saat menyimpan data: " . $stmt->error;
                }

                // Close the prepared statement
                $stmt->close();
            }
        } else {
            echo "Maaf, terjadi kesalahan saat mengunggah file.";
        }
    }
}

// Close the database connection
$conn->close();
?>