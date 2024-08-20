<?php
require_once("include/connection.php");

if (isset($_POST['reguser'])) {
    $user_name = mysqli_real_escape_string($conn, trim($_POST['name']));
    $email_address = mysqli_real_escape_string($conn, trim($_POST['email_address']));
    $user_password = password_hash(trim($_POST['user_password']), PASSWORD_DEFAULT, ['cost' => 12]);
    $user_status = mysqli_real_escape_string($conn, trim($_POST['user_status']));

    // Check if the email already exists
    $stmt = $conn->prepare("SELECT * FROM `login_user` WHERE `email_address` = ?");
    $stmt->bind_param("s", $email_address);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    if ($result->num_rows > 0) {
        echo '
            <script type="text/javascript">
                alert("Email Address already taken");
                window.location = "dashboard.php";
            </script>
        ';
    } else {
        // Insert the new user into the database
        $stmt = $conn->prepare("INSERT INTO `login_user` (name, email_address, user_password, user_status) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $user_name, $email_address, $user_password, $user_status);

        if ($stmt->execute()) {
            echo '
                <script type="text/javascript">
                    alert("Saved Employee Info");
                    window.location = "dashboard.php";
                </script>
            ';
        } else {
            echo '
                <script type="text/javascript">
                    alert("Error: Could not save employee info.");
                    window.location = "dashboard.php";
                </script>
            ';
        }
        $stmt->close();
    }
    $conn->close();
}
?>
