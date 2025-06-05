<?php
include '../../../koneksi.php'; // Include the database connection file

// Check if the form is submitted via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve the submitted form data
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];

    // Define the target directory for uploaded images
    $target_dir = "../../../storage/keunggulan/";
    
    // Generate a unique filename to avoid conflicts
    $file_extension = strtolower(pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION));
    $unique_name = uniqid('kg', true) . rand(1000, 9999) . '.' . $file_extension;
    $target_file = $target_dir . $unique_name; // Full path to save the file

    $uploadOk = 1;

    // Verify if the uploaded file is an actual image
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["foto"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File bukan gambar.";
            $uploadOk = 0;
        }
    }

    // Check if a file with the same name already exists (unlikely due to unique naming)
    if (file_exists($target_file)) {
        echo "Maaf, file sudah ada.";
        $uploadOk = 0;
    }

    // Limit file size to 5MB
    if ($_FILES["foto"]["size"] > 5000000) {
        echo "Maaf, ukuran file terlalu besar.";
        $uploadOk = 0;
    }

    // Allow only JPG, JPEG, PNG, and GIF file formats
    if ($file_extension != "jpg" && $file_extension != "png" && $file_extension != "jpeg") {
        echo "Maaf, hanya file JPG, JPEG & PNG yang diperbolehkan.";
        $uploadOk = 0;
    }

    // If any validation failed, do not proceed with upload
    if ($uploadOk == 0) {
        echo "Maaf, file Anda gagal diunggah.";
    } else {
        // Try to move the uploaded file to the target directory
        if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
            // Prepare SQL query to insert data into the database
            $sql = "INSERT INTO keunggulan (judul, deskripsi, foto) VALUES (?, ?, ?)";

            if ($stmt = $conn->prepare($sql)) {
                // Bind parameters: title, description, and filename only
                $stmt->bind_param("sss", $judul, $deskripsi, $unique_name);

                // Execute the prepared statement
                if ($stmt->execute()) {
                    // Redirect with success status
                    header("Location: create.php?status=success");
                    exit();
                } else {
                    echo "Error: " . $stmt->error;
                }

                // Close the statement
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