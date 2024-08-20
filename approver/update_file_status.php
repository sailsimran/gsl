<?php
require_once("include/connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && isset($_POST['status'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    $query = "UPDATE files SET status = '$status' WHERE id = '$id'";
    if (mysqli_query($conn, $query)) {
        echo 'success';
    } else {
        echo 'error';
    }
}
?>
