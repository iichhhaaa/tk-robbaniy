<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['nama'])) {
    header('Location: login.php');
    exit();
}

$nama = $_SESSION['nama'];
include '../../../koneksi.php'; // Include the database connection file

// Check if 'id' is passed in the URL
if (isset($_POST['id'])) {
    $id = $_POST['id']; // Get the 'id' from the form
    $nama = $_POST['nama'];
    $jabatan = $_POST['jabatan'];

    // Fetch the existing record to check for the old photo file
    $sql_fetch = "SELECT foto FROM guru WHERE id = ?";
    if ($stmt_fetch = $conn->prepare($sql_fetch)) {
        $stmt_fetch->bind_param("i", $id);
        $stmt_fetch->execute();
        $result_fetch = $stmt_fetch->get_result();

        // If record exists, fetch the current photo filename
        if ($result_fetch->num_rows > 0) {
            $row = $result_fetch->fetch_assoc();
            $old_foto = $row['foto']; // Store the existing photo filename
        } else {
            echo "Data tidak ditemukan!";
            exit();
        }
        $stmt_fetch->close();
    }

    // Check if a new file is uploaded
    if ($_FILES["foto"]["name"] != "") {
        // Handle file upload for 'foto'
        $target_dir = "../../../storage/guru/"; // Directory to store uploaded image
        
        // Generate a unique file name using uniqid() and rand()
        $file_extension = strtolower(pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION));
        $unique_name = uniqid('guru', true) . rand(1000, 9999) . '.' . $file_extension;
        $target_file = $target_dir . $unique_name; // Full path where file will be saved

        $uploadOk = 1;

        // Check if uploaded file is a valid image
        $check = getimagesize($_FILES["foto"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File bukan gambar.";
            $uploadOk = 0;
        }

        // Check if the file already exists
        if (file_exists($target_file)) {
            echo "Maaf, file sudah ada.";
            $uploadOk = 0;
        }

        // Check file size (limit: 5MB)
        if ($_FILES["foto"]["size"] > 5000000) {
            echo "Maaf, ukuran file terlalu besar.";
            $uploadOk = 0;
        }

        // Allow only specific file formats
        if ($file_extension != "jpg" && $file_extension != "png" && $file_extension != "jpeg" && $file_extension != "gif") {
            echo "Maaf, hanya file JPG, JPEG, PNG, dan GIF yang diperbolehkan.";
            $uploadOk = 0;
        }

        // Check if upload is still allowed
        if ($uploadOk == 0) {
            echo "Maaf, file Anda tidak berhasil diunggah.";
        } else {
            // Try to upload the file
            if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
                // If upload success, set new file name
                $foto = $unique_name;

                // Delete old photo file if it exists
                if (file_exists($target_dir . $old_foto)) {
                    unlink($target_dir . $old_foto); // Remove old file from server
                }
            } else {
                echo "Maaf, terjadi kesalahan saat mengunggah file.";
            }
        }
    } else {
        // If no new file is uploaded, retain old photo filename
        $foto = $old_foto;
    }

    // Prepare SQL query to update the data
    $sql_update = "UPDATE guru SET nama = ?, jabatan = ?, foto = ? WHERE id = ?";

    if ($stmt_update = $conn->prepare($sql_update)) {
        // Bind the parameters
        $stmt_update->bind_param("sssi", $nama, $jabatan, $foto, $id);

        // Execute the query
        if ($stmt_update->execute()) {
            // Redirect to success page or show success message
            header("Location: update.php?id=$id&status=success");
        } else {
            echo "Kesalahan: " . $stmt_update->error;
        }

        // Close the statement
        $stmt_update->close();
    }

    // Close database connection
    $conn->close();
}
?>