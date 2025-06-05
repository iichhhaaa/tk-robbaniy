<?php
include '../../../koneksi.php'; // Include the database connection file

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $judul = $_POST['judul'];

    // Handle file upload for 'foto'
    $target_dir = "../../../storage/galeri/"; // Directory to store the uploaded image
    
    // Generate a unique file name using uniqid() and rand()
    $file_extension = strtolower(pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION));
    $unique_name = uniqid('galeri', true) . rand(1000, 9999) . '.' . $file_extension;
    $target_file = $target_dir . $unique_name; // The full path where the file will be stored

    $uploadOk = 1;

    // Check if image file is a valid image or not
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["foto"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File yang Anda unggah bukan gambar.";
            $uploadOk = 0;
        }
    }

    // Check if the file already exists (though the unique name should prevent this)
    if (file_exists($target_file)) {
        echo "Maaf, file sudah ada.";
        $uploadOk = 0;
    }

    // Check file size (limit to 5MB)
    if ($_FILES["foto"]["size"] > 5000000) {
        echo "Maaf, ukuran file terlalu besar.";
        $uploadOk = 0;
    }

    // Allow only certain file formats
    if ($file_extension != "jpg" && $file_extension != "png" && $file_extension != "jpeg") {
        echo "Maaf, hanya file JPG, JPEG & PNG yang diperbolehkan.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Maaf, file Anda gagal diunggah.";
    } else {
        // If everything is fine, try to upload the file
        if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
            // Prepare an SQL query to insert the data into the database
            $sql = "INSERT INTO galeri (judul, foto) VALUES (?, ?)";

            if ($stmt = $conn->prepare($sql)) {
                // Bind the parameters
                $stmt->bind_param("ss", $judul, $unique_name);

                // Execute the query
                if ($stmt->execute()) {
                    // Redirect to create.php with status=success
                    header("Location: create.php?status=success");
                    exit();
                } else {
                    echo "Terjadi kesalahan: " . $stmt->error;
                }

                // Close the statement
                $stmt->close();
            }
        } else {
            echo "Maaf, terjadi kesalahan saat mengunggah file Anda.";
        }
    }
}

// Close the database connection
$conn->close();
?>