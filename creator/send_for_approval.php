<?php
require_once("include/connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['fileUpload'])) {
    $fileName = $_FILES['fileUpload']['name'];
    $fileTmpName = $_FILES['fileUpload']['tmp_name'];
    $fileSize = $_FILES['fileUpload']['size'];
    $fileError = $_FILES['fileUpload']['error'];
    $fileType = $_FILES['fileUpload']['type'];

    if ($fileError === 0) {
        // Ensure the upload directory exists
        $uploadDir = '/filemanagement/uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileDestination = $uploadDir . basename($fileName);
        if (move_uploaded_file($fileTmpName, $fileDestination)) {
            // Ensure file name and status are properly escaped to prevent SQL injection
            $fileNameEscaped = mysqli_real_escape_string($conn, $fileName);
            $sql = "INSERT INTO files (file_name, status) VALUES ('$fileNameEscaped', 'Pending')";
            if (mysqli_query($conn, $sql)) {
                echo "<script>alert('File uploaded successfully!'); window.location.href='dashboard.php';</script>";
            } else {
                echo "<script>alert('Database insertion error: " . mysqli_error($conn) . "'); window.location.href='dashboard.php';</script>";
            }
        } else {
            echo "<script>alert('Failed to move the uploaded file.'); window.location.href='dashboard.php';</script>";
        }
    } else {
        echo "<script>alert('There was an error uploading your file.'); window.location.href='dashboard.php';</script>";
    }
}
?>
