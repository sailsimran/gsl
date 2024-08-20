<!DOCTYPE html>
<html lang="en">
<?php
session_start();
if (!isset($_SESSION["email_address"])) {
    header("location:../home.php");
    exit();
}
?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Approver Dashboard</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="css/mdb.min.css" rel="stylesheet">
    <!-- Your custom styles (optional) -->
    <link href="css/style.css" rel="stylesheet">
    <!-- Datatables CSS and JS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.9/css/jquery.dataTables.min.css"/>   
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/1.0.3/css/dataTables.responsive.css">
    <script src="js/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" charset="utf-8">
        $(document).ready(function () {
            $('#dtable').dataTable({
                "aLengthMenu": [[5, 10, 15, 25, 50, 100, -1], [5, 10, 15, 25, 50, 100, "All"]],
                "iDisplayLength": 10,
                "searching": false // Disable search feature
            });
            $('#historyTable').dataTable({
                "aLengthMenu": [[5, 10, 15, 25, 50, 100, -1], [5, 10, 15, 25, 50, 100, "All"]],
                "iDisplayLength": 10,
                "searching": false // Disable search feature
            });

            // Show file description on filename click
            $('.filename-link').on('click', function () {
                var description = $(this).data('description');
                $('#file-description').text(description);
            });

            // Move row to history on approve/reject
            $('.approve-btn, .reject-btn').on('click', function () {
                var row = $(this).closest('tr');
                var action = $(this).hasClass('approve-btn') ? 'Approved' : 'Rejected';
                var fileId = $(this).data('id');
                updateFileStatus(fileId, action, row);
            });
        });

        function updateFileStatus(fileId, action, row) {
            $.ajax({
                url: 'update_file_status.php',
                method: 'POST',
                data: { id: fileId, status: action },
                success: function(response) {
                    if (response === 'success') {
                        moveToHistory(row, action);
                    } else {
                        alert('Error updating file status.');
                    }
                }
            });
        }

        function moveToHistory(row, action) {
            var filename = row.find('.filename-link').text();
            var date = row.find('.file-date').text();
            $('#historyTable tbody').append('<tr><td>' + filename + '</td><td>' + date + '</td><td>' + action + '</td></tr>');
            row.remove();
        }
    </script>
    <style type="text/css">
        #loader {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url('img/lg.flip-book-loader.gif') 50% 50% no-repeat rgb(249, 249, 249);
            opacity: 1;
        }

        .navbar-brand img {
            width: 50px;
            height: 50px;
        }

        .navbar-brand span {
            font-size: 1.5rem;
        }

        .nav-link {
            font-size: 1.25rem;
        }

        h3 {
            font-size: 2rem;
            text-align: center;
        }

        .table {
            font-size: 1.1rem;
        }

        #file-description {
            font-size: 1rem;
            margin-top: 20px;
        }
    </style>
    <script type="text/javascript">
        $(window).on('load', function () {
            setTimeout(function () {
                $('#loader').fadeOut('slow');
            });
        });
    </script>
</head>

<body style="padding:0px; margin:0px; background-color:#fff;font-family:arial,helvetica,sans-serif,verdana,'Open Sans'">
<?php
require_once("include/connection.php");

$id = mysqli_real_escape_string($conn, $_SESSION['email_address']);
$r = mysqli_query($conn, "SELECT * FROM login_user WHERE email_address = '$id'") or die(mysqli_error($conn));
$row = mysqli_fetch_array($r);

?>

<!--Navbar -->
<nav class="mb-1 navbar navbar-expand-lg navbar-dark" style="background-color: navy;">
    <a class="navbar-brand" href="#">
        <img src="img/goa_shipyard_logo.png" alt="GSL Logo">
        <span style="color: white; font-weight: bold;">Goa Shipyard Limited (GSL)</span>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-4"
            aria-controls="navbarSupportedContent-4" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-4" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    <font color="black">Welcome!,</font> <?php echo ucwords(htmlentities($id)); ?> <i class="fas fa-user-circle"></i> Login
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-info" aria-labelledby="navbarDropdownMenuLink-4">
                    <a class="dropdown-item" href="history_log.php"><i class="fas fa-chalkboard-teacher"></i> User Logged</a>
                    <a class="dropdown-item" href="Logout.php"><i class="fas fa-sign-in-alt"></i> LogOut</a>
                </div>
            </li>
        </ul>
    </div>
</nav>
<br><br><br>
<!--/.Navbar -->
<!-- Card -->
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <hr>
            <h3>Approver Dashboard</h3>
            <table id="dtable" class="table table-striped">
                <thead>
                <tr>
                    <th>Creator</th>
                    <th>Filename</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $query = mysqli_query($conn, "SELECT * FROM files WHERE status = 'Pending'") or die(mysqli_error($conn));
                while ($file = mysqli_fetch_array($query)) {
                    $id = $file['id'];
                    $name = $file['file_name'];
                    $uploads = $file['file_name'];
                    $time = $file['uploaded_at'];
                 
                    ?>
                    <tr>
                        <td><?php echo $uploads; ?></td>
                        <td><a href="#" class="filename-link" data-description="<?php echo $description; ?>"><?php echo $name; ?></a></td>
                        <td class="file-date"><?php echo $time; ?></td>
                        <td>
                            <button class="btn btn-success btn-sm approve-btn" data-id="<?php echo $id; ?>">Approve</button>
                            <button class="btn btn-danger btn-sm reject-btn" data-id="<?php echo $id; ?>">Reject</button>
                            <button class="btn btn-primary btn-sm" onclick="viewDocument('<?php echo $name; ?>')">View Document</button>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="col-md-4">
            <hr>
            <h3>File Description</h3>
            <div id="file-description">Select a file to see its description here.</div>
        </div>
        <div class="col-md-12">
            <hr>
            <h3>History</h3>
            <table id="historyTable" class="table table-striped">
                <thead>
                <tr>
                    <th>Filename</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                // Assuming you have a history_log table with relevant data
                $historyQuery = mysqli_query($conn, "SELECT file_name, uploaded_at, status FROM files WHERE status != 'Pending'") or die(mysqli_error($conn));
                while ($history = mysqli_fetch_array($historyQuery)) {
                    $filename = $history['file_name'];
                    $date = $history['uploaded_at'];
                    $action = $history['status'];
                    ?>
                    <tr>
                        <td><?php echo $filename; ?></td>
                        <td><?php echo $date; ?></td>
                        <td><?php echo $action; ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- /Card -->

<!-- SCRIPTS -->
<!-- JQuery -->
<script type="text/javascript" src="js/jquery-3.4.0.min.js"></script>
<script type="text/javascript" src="js/popper.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/mdb.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/responsive/1.0.3/js/dataTables.responsive.js"></script>
<script type="text/javascript">
    function viewDocument(filename) {
        window.open('/filemanagement/uploads/' + filename, '_blank');

    }
</script>

</body>
</html>
