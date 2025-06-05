<?php
include '../../../koneksi.php'; // Include the database connection file

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $nama = $_POST['nama'];
    $jabatan = $_POST['jabatan'];

    // Define the directory to store the uploaded photo
    $target_dir = "../../../storage/guru/";

    // Generate a unique file name to prevent conflicts
    $file_extension = strtolower(pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION));
    $unique_name = uniqid('guru', true) . rand(1000, 9999) . '.' . $file_extension;
    $target_file = $target_dir . $unique_name;

    $uploadOk = 1;

    // Validate the uploaded file is an image
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["foto"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File bukan gambar yang valid.";
            $uploadOk = 0;
        }
    }

    // Check if file already exists (should not happen due to unique name)
    if (file_exists($target_file)) {
        echo "Maaf, file sudah ada.";
        $uploadOk = 0;
    }

    // Check file size limit (max 5MB)
    if ($_FILES["foto"]["size"] > 5000000) {
        echo "Maaf, ukuran file terlalu besar. Maksimal 5MB.";
        $uploadOk = 0;
    }

    // Allow only certain file types
    if ($file_extension != "jpg" && $file_extension != "png" && $file_extension != "jpeg") {
        echo "Maaf, hanya file JPG, JPEG & PNG yang diperbolehkan.";
        $uploadOk = 0;
    }

    // If upload validation fails
    if ($uploadOk == 0) {
        echo "Maaf, file tidak berhasil diunggah.";
    } else {
        // Attempt to move the uploaded file to the target directory
        if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
            // Prepare SQL statement to insert data
            $sql = "INSERT INTO guru (nama, jabatan, foto) VALUES (?, ?, ?)";

            if ($stmt = $conn->prepare($sql)) {
                // Bind parameters and execute
                $stmt->bind_param("sss", $nama, $jabatan, $unique_name);

                if ($stmt->execute()) {
                    // Redirect to create.php with success status
                    header("Location: create.php?status=success");
                    exit();
                } else {
                    echo "Terjadi kesalahan pada penyimpanan data: " . $stmt->error;
                }

                // Close the statement
                $stmt->close();
            }
        } else {
            echo "Maaf, terjadi kesalahan saat mengunggah file.";
        }
    }
}

// Close database connection
$conn->close();
?>