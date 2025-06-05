<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['nama'])) {
    // If not logged in, redirect to login page
    header('Location: ../../../login.php');
    exit();
}

// Check if the user role is admin
if ($_SESSION['role'] !== 'admin') {
    // If role is not admin, redirect to dashboard
    header('Location: ../dashboard-capen/index.php');
    exit();
}

$nama = $_SESSION['nama'];

include '../../../koneksi.php'; // Include the database connection file

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $id = $_POST['id'];
    $judul = $_POST['judul'];

    // Fetch the existing record to check for the old photo file
    $sql_fetch = "SELECT foto FROM galeri WHERE id = ?";
    if ($stmt_fetch = $conn->prepare($sql_fetch)) {
        $stmt_fetch->bind_param("i", $id);
        $stmt_fetch->execute();
        $result_fetch = $stmt_fetch->get_result();

        // If record exists, fetch the current photo filename
        if ($result_fetch->num_rows > 0) {
            $row = $result_fetch->fetch_assoc();
            $old_foto = $row['foto']; // The existing photo filename
        } else {
            echo "Data tidak ditemukan!";
            exit();
        }
        $stmt_fetch->close();
    }

    // Check if a new file is uploaded
    if ($_FILES["foto"]["name"] != "") {
        // Handle file upload for 'foto'
        $target_dir = "../../../storage/galeri/"; // Directory to store the uploaded image
        
        // Generate a unique file name using uniqid() and rand()
        $file_extension = strtolower(pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION));
        $unique_name = uniqid('galeri', true) . rand(1000, 9999) . '.' . $file_extension;
        $target_file = $target_dir . $unique_name; // The full path where the file will be stored

        $uploadOk = 1;

        // Check if image file is a valid image or not
        $check = getimagesize($_FILES["foto"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File yang Anda upload bukan gambar.";
            $uploadOk = 0;
        }

        // Check if the file already exists
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
        if ($file_extension != "jpg" && $file_extension != "png" && $file_extension != "jpeg" && $file_extension != "gif") {
            echo "Maaf, hanya file JPG, JPEG, PNG & GIF yang diperbolehkan.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Maaf, file Anda gagal diupload.";
        } else {
            // If everything is fine, try to upload the file
            if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
                // If a new file is uploaded, use the new file name
                $foto = $unique_name; // Update the file name for the photo

                // Delete the old photo if it exists
                if (file_exists($target_dir . $old_foto)) {
                    unlink($target_dir . $old_foto); // Delete the old photo from the server
                }
            } else {
                echo "Maaf, terjadi kesalahan saat mengupload file.";
            }
        }
    } else {
        // If no new file is uploaded, retain the old file name
        $foto = $old_foto; // Retain the existing photo name
    }

    // Prepare an SQL query to update the data in the database
    $sql_update = "UPDATE galeri SET judul = ?, foto = ? WHERE id = ?";

    if ($stmt_update = $conn->prepare($sql_update)) {
        // Bind the parameters
        $stmt_update->bind_param("ssi", $judul, $foto, $id);

        // Execute the query
        if ($stmt_update->execute()) {
            // Redirect to the success page or show a success message
            header("Location: update.php?id=$id&status=success");
        } else {
            echo "Error: " . $stmt_update->error;
        }

        // Close the statement
        $stmt_update->close();
    }

    // Close the database connection
    $conn->close();
}
?>