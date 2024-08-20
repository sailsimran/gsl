<?php
// connect to the database
require_once("include/connection.php");

// Uploads files
if (isset($_POST['save'])) { // if save button on the form is clicked
    // name of the uploaded file
    $user = $_POST['email'];
    $category = $_POST['category']; // Get the selected category

    $filename = $_FILES['myfile']['name'];

    // destination of the file on the server
    $destination = '../uploads/' . $filename;

    // get the file extension
    $extension = pathinfo($filename, PATHINFO_EXTENSION);

    // the physical file on a temporary uploads directory on the server
    $file = $_FILES['myfile']['tmp_name'];
    $size = $_FILES['myfile']['size'];

    if (!in_array($extension, ['pdf'])) {
        echo '<script type="text/javascript">
                  alert("Your file extension must be: .pdf");
                  window.location = "add_file.php";
              </script>';
    } elseif ($_FILES['myfile']['size'] > 2000000) { // file shouldn't be larger than 2 Megabytes
        echo "File too large!";
    } else {
        $query = mysqli_query($conn, "SELECT * FROM `upload_files` WHERE `name` = '$filename'") or die(mysqli_error($conn));
        $counter = mysqli_num_rows($query);

        if ($counter == 1) {
            echo '<script type="text/javascript">
                      alert("File already exists");
                      window.location = "add_document.php";
                  </script>';
        } else {
            date_default_timezone_set("asia/manila");
            $time = date("M-d-Y h:i A", strtotime("+0 HOURS"));

            // move the uploaded (temporary) file to the specified destination
            if (move_uploaded_file($file, $destination)) {
                $sql = "INSERT INTO upload_files (name, size, download, timers, admin_status, email, category) VALUES ('$filename', $size, 0, '$time', 'Admin', '$user', '$category')";
                if (mysqli_query($conn, $sql)) {
                    echo '<script type="text/javascript">
                              alert("File Uploaded Successfully");
                              window.location = "add_document.php";
                          </script>';
                }
            } else {
                echo "Failed to upload file!";
            }
        }
    }
}
?>
