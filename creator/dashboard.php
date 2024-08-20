<!DOCTYPE html>
<html lang="en">
<?php
session_start();
if (!isset($_SESSION["admin_user"])) {
    header("location:index.html");
    exit();
} else {
    $uname = $_SESSION['admin_user'];
}
?>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>DATABASE MANAGEMENT SYSTEM</title>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
  <!-- Bootstrap core CSS -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <!-- Material Design Bootstrap -->
  <link href="css/mdb.min.css" rel="stylesheet">
  <!-- Your custom styles (optional) -->
  <link href="css/style.min.css" rel="stylesheet">
  <style>
    #loader {
        position: fixed;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: url('img/lg.flip-book-loader.gif') 50% 50% no-repeat rgb(249,249,249);
        opacity: 1;
    }
    .navbar-custom {
        background-color: #002366;
    }
    .navbar-brand{
      padding-left:320px;
    }
    .navbar-custom ,
    .navbar-custom .nav-link,
    .navbar-custom .navbar-text {
        color: #fff;
    }
    .navbar-brand img {
        height: 40px;
        margin-right: 10px;
    }
    .navbar-brand .navbar-text {
        font-size: 1.2rem;
        font-weight: bold;
    }
    .dark-blue-border {
        border: 2px solid #00008B;
    }
    .sidebar-fixed {
        width: 250px;
        height: 100%;
        position: fixed;
        background-color: white;
        color: white;
        padding-top: 40px;
        margin-top :80px;
    }
    .sidebar-fixed .list-group-item {
        background-color: #002366;
        color: white;
        border: none;
    }
    .sidebar-fixed .list-group-item.active {
        background-color: #001b4d;
    }
    .sidebar-fixed .list-group-item:hover {
        background-color: #001b4d;
    }
    .sidebar-fixed .logo-wrapper {
        text-align: center;
        margin-bottom: 20px;
        padding: 10px;
        background: none;
    }
    .sidebar-fixed .logo-wrapper img {
        height: 350px;
        display: block;
        margin-left: 50px;
        margin-right: auto;
        width: 100px;
    }
  </style>
  <script src="js/jquery-3.4.0.min.js"></script>
  <script type="text/javascript">
    $(window).on('load', function(){
      setTimeout(function(){
          $('#loader').fadeOut('slow');  
      });
    });
  </script>
</head>

<body class="grey lighten-3">

  <!--Main Navigation-->
  <header>
    <nav class="navbar fixed-top navbar-expand-lg navbar-light scrolling-navbar navbar-custom">
      <div class="container-fluid">
        <!-- Brand -->
        <a class="navbar-brand" href="#">
          <img src="img/GSLL.png" alt="GSL Logo">
          <span class="navbar-text">GOA SHIPYARD LIMITED</span>
        </a>
        <!-- Collapse -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Links -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
            <a href="logout.php" class="nav-link border border-light rounded waves-effect" style="color: white;">
  <i class="far fa-user-circle" style="color: white;"></i> SignOut
</a>

            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- Navbar -->
    <div id="loader"></div>
    <div class="sidebar-fixed dark-blue-border">
      <a class="logo-wrapper waves-effect">
      </a>
      <div class="list-group list-group-flush">
        <a href="dashboard.php" class="list-group-item active waves-effect">
          <i class="fas fa-chart-pie mr-3"></i>Dashboard
        </a>
        <a href="add_document.php" class="list-group-item list-group-item-action waves-effect">
          <i class="fas fa-file-medical"></i> Add Document
        </a>
      </div>
    </div>
    <!-- Sidebar -->
  </header>

  <!--Main layout-->
  <main class="pt-5 mx-lg-5">
    <div class="container-fluid mt-5">

      <!-- Heading -->
      <div class="card mb-4 wow fadeIn dark-blue-border">
        <!--Card content-->
        <div class="card-body d-sm-flex justify-content-between">
          <h4 class="mb-2 mb-sm-0 pt-1">
            <a href="dashboard.php">Home Page</a>
            <span>/</span>
            <span>Dashboard</span>
          </h4>
        </div>
      </div>
      <!-- Heading -->

      <!-- Grid row -->
      <div class="row wow fadeIn">

        <!-- Grid column -->
        <div class="col-md-12 mb-4">
          <!-- Card -->
          <div class="card dark-blue-border">
            <!-- Card content -->
            <div class="card-body">
              <form action="send_for_approval.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                  <label for="fileUpload">Upload File for Approval:</label>
                  <input type="file" class="form-control-file" id="fileUpload" name="fileUpload" required>
                </div>
                <button type="submit" class="btn btn-primary">Send for Approval</button>
              </form>
              <hr>
              <h5>Approved and Rejected Files</h5>
              <?php
                require_once("include/connection.php");

                $result = mysqli_query($conn, "SELECT * FROM files") or die(mysqli_error($conn));

                echo '<table class="table table-striped dark-blue-border">';
                echo '<thead><tr><th>ID</th><th>File Name</th><th>Status</th></tr></thead>';
                echo '<tbody>';

                while ($row = mysqli_fetch_array($result)) {
                  echo '<tr>';
                  echo '<td>' . htmlentities($row['id']) . '</td>';
                  echo '<td>' . htmlentities($row['file_name']) . '</td>';
                  echo '<td>' . htmlentities($row['status']) . '</td>';
                  echo '</tr>';
                }

                echo '</tbody>';
                echo '</table>';
              ?>
            </div>
          </div>
          <!-- /.Card -->
        </div>
        <!-- Grid column -->

      </div>
      <!-- Grid row -->

    </div>
  </main>
  <!--Main layout-->

  <!-- SCRIPTS -->
  <!-- JQuery -->
  <script type="text/javascript" src="js/jquery-3.4.0.min.js"></script>
  <!-- Bootstrap tooltips -->
  <script type="text/javascript" src="js/popper.min.js"></script>
  <!-- Bootstrap core JavaScript -->
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <!-- MDB core JavaScript -->
  <script type="text/javascript" src="js/mdb.min.js"></script>
</body>
</html>
