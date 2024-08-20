<!DOCTYPE html>
<html lang="en">
<?php

session_start();
if (!isset($_SESSION["admin_user"])) {
    header("location:index.html");
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
    .navbar{
      color:#003366;
    }

    .map-container{
        overflow:hidden;
        padding-bottom:56.25%;
        position:relative;
        height:0;
    }
    .map-container iframe{
        left:0;
        top:0;
        height:100%;
        width:100%;
        position:absolute;
    }
 
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
    /* Modal styles */
    .modal-header {
        background-color: #002366; /* Match your navbar color or use a consistent color */
        color: #fff;
    }

    .modal-title {
        font-weight: bold;
    }

    .modal-body {
        padding: 2rem;
    }

    /* Style for the status selection buttons */
    .btn-group-toggle .btn {
        border-radius: 0.25rem;
        margin: 0.1rem;
        padding: 0.25rem 0.5rem; /* Make buttons smaller */
    }

    .btn-group-toggle .btn input[type="radio"] {
        display: none;
    }

    .btn-group-toggle .btn input[type="radio"]:checked + .btn {
        background-color: #002366; /* Match your primary color */
        color: #fff;
        border-color: #002366;
    }

    .btn-group-toggle .btn-outline-primary {
        color: #002366; /* Match your primary color */
        border-color: #002366;
    }

    .btn-group-toggle .btn-outline-primary.active,
    .btn-group-toggle .btn-outline-primary:active {
        background-color: #002366; /* Match your primary color */
        color: #fff;
        border-color: #002366;
    }

    .status-label {
  /* Move the label up */
  margin-bottom: 85px; /* Adjust this value to move the text up */
  font-weight: bold;
}

.status-buttons {
  /* Optional: Adjust the margin to control spacing below the buttons */
  margin-top: 0; /* Ensure there’s no extra margin pushing the buttons down */
}

.status-button {
  /* Optional: Adjust spacing between buttons */
  margin-right: 5px; /* Adjust margin if needed */
}


  </style>

  <script src="jquery.min.js"></script>
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
          <img src="img/GSL.jpg" alt="GSL Logo">
          <span class="navbar-text">GOA SHIPYARD LIMITED</span>
        </a>

        <!-- Collapse -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Links -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">

          <!-- Left -->
          <ul class="navbar-nav mr-auto"></ul>
          <?php 
            require_once("include/connection.php");
            $id = mysqli_real_escape_string($conn, $_SESSION['admin_user']);
            $r = mysqli_query($conn, "SELECT * FROM admin_login where id = '$id'") or die (mysqli_error($con));
            $row = mysqli_fetch_array($r);
            $fname = $row['name'];
          ?>
          <!-- Right -->
          <ul class="navbar-nav nav-flex-icons">
            <li style="margin-top: 10px;">Welcome!, <?php echo ucwords(htmlentities($fname)); ?></li>
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

    <!-- Sidebar -->
      <div id="loader"></div>
    <div class="sidebar-fixed position-fixed dark-blue-border">
      <a class="logo-wrapper waves-effect">
      </a>
      <div class="list-group list-group-flush">
        <a href="dashboard.php" class="list-group-item active waves-effect">
          <i class="fas fa-chart-pie mr-3"></i>Dashboard
        </a>
        <a href="#" class="list-group-item list-group-item-action waves-effect" data-toggle="modal" data-target="#modalRegisterForm">
          <i class="fas fa-user mr-3"></i>Add Admin</a>
        <a href="view_admin.php" class="list-group-item list-group-item-action waves-effect">
          <i class="fas fa-users"></i> View Admin</a>
        <a href="#" class="list-group-item list-group-item-action waves-effect" data-toggle="modal" data-target="#modalRegisterForm2">
          <i class="fas fa-user mr-3"></i>Add User</a>
        <a href="view_user.php" class="list-group-item list-group-item-action waves-effect">
          <i class="fas fa-users"></i> View User</a>
        <a href="admin_log.php" class="list-group-item list-group-item-action waves-effect">
          <i class="fas fa-chalkboard-teacher"></i> Admin logged</a>
        <a href="user_log.php" class="list-group-item list-group-item-action waves-effect">
          <i class="fas fa-chalkboard-teacher"></i> User logged</a>
      </div>
    </div>
    <!-- Sidebar -->

  </header>

  <!--Add admin-->
  <div class="modal fade" id="modalRegisterForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form action="create_Admin.php" method="POST">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header text-center">
            <h4 class="modal-title w-100 font-weight-bold"><i class="fas fa-user-plus"></i> Add Admin</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body mx-3">
            <div class="md-form mb-5">
              <i class="fas fa-user prefix grey-text"></i>
              <input type="text" id="orangeForm-name" name="name" class="form-control validate" required="">
              <label data-error="wrong" data-success="right" for="orangeForm-name">Your name</label>
            </div>
            <div class="md-form mb-5">
              <i class="fas fa-envelope prefix grey-text"></i>
              <input type="email" id="orangeForm-email" name="admin_user" class="form-control validate" required="">
              <label data-error="wrong" data-success="right" for="orangeForm-email">Your email</label>
            </div>
            <div class="md-form mb-4">
              <i class="fas fa-lock prefix grey-text"></i>
              <input type="password" id="orangeForm-pass" name="admin_password" class="form-control validate" required="">
              <label data-error="wrong" data-success="right" for="orangeForm-pass">Your password</label>
            </div>
            <div class="md-form mb-4">
              <i class="fas fa-user prefix grey-text"></i>
              <input type="text" id="orangeForm-pass" name="admin_status" value="Admin" class="form-control validate" readonly="">
              <label data-error="wrong" data-success="right" for="orangeForm-pass">User Status</label>
            </div>
          </div>
          <div class="modal-footer d-flex justify-content-center">
            <button class="btn btn-info" name="reg">Sign up</button>
          </div>
        </div>
      </div>
    </form>
  </div>
  <!--end modaladmin-->

<!-- Add User Modal -->
<div class="modal fade" id="modalRegisterForm2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="create_user.php" method="POST">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header text-center">
          <h4 class="modal-title w-100 font-weight-bold"><i class="fas fa-user-plus"></i> Add User Employee</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body mx-3">
          <div class="md-form mb-5">
            <i class="fas fa-user prefix grey-text"></i>
            <input type="text" id="orangeForm-name" name="name" class="form-control validate" required>
            <label for="orangeForm-name">Your name</label>
          </div>
          <div class="md-form mb-5">
            <i class="fas fa-envelope prefix grey-text"></i>
            <input type="email" id="orangeForm-email" name="email_address" class="form-control validate" required>
            <label for="orangeForm-email">Your email</label>
          </div>
          <div class="md-form mb-4">
            <i class="fas fa-lock prefix grey-text"></i>
            <input type="password" id="orangeForm-pass" name="user_password" class="form-control validate" required>
            <label for="orangeForm-pass">Your password</label>
          </div>
          <div class="md-form mb-5">
            <label for="orangeForm-status" class="status-label"></label>
            <div class="btn-group btn-group-toggle d-flex status-buttons" data-toggle="buttons">
              <label class="btn btn-outline-primary btn-sm status-button">
                <input type="radio" name="user_status" value="Creator" required> Creator
              </label>
              <label class="btn btn-outline-primary btn-sm status-button">
                <input type="radio" name="user_status" value="Approver" required> Approver
              </label>
              <label class="btn btn-outline-primary btn-sm status-button">
                <input type="radio" name="user_status" value="Employee" required> Employee
              </label>
            </div>
          </div>
        </div>
        <div class="modal-footer d-flex justify-content-center">
          <button class="btn btn-info" name="reguser" type="submit">Sign up</button>
        </div>
      </div>
    </div>
  </form>
</div>
<!-- End Add User Modal -->



<!-- Main layout -->
<main class="pt-5 mx-lg-5">
  <div class="container-fluid mt-5">

    <!-- Heading -->
    <div class="card mb-4 wow fadeIn">

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

    <!-- Content section for Goa Shipyard Limited -->
    <div class="card mb-4">
      <div class="card-body">
        <h4 class="card-title">Goa Shipyard Limited</h4>
        <p class="card-text">
          Goa Shipyard Limited (GSL) is a leading shipyard located on the West Coast of India, engaged in building and repairing ships for the Indian Navy and Indian Coast Guard. Established in 1957, GSL has built a reputation for delivering high-quality ships on time and within budget.
        </p>
        <p class="card-text">
          Over the years, GSL has diversified its product range to include a wide variety of vessels such as offshore patrol vessels, fast patrol vessels, missile boats, and other specialized craft. The shipyard is equipped with modern infrastructure and state-of-the-art facilities to undertake construction of complex and sophisticated ships.
        </p>
        <p class="card-text">
          GSL's commitment to excellence, innovation, and customer satisfaction has made it a trusted partner for maritime solutions. The shipyard's strategic location, experienced workforce, and focus on continuous improvement ensure that it remains at the forefront of the shipbuilding industry.
        </p>
      </div>
    </div>
    <!-- End Content section -->

  </div>
</main>
<!-- Main layout -->

<!-- SCRIPTS -->
<!-- JQuery -->
<script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
<!-- Bootstrap tooltips -->
<script type="text/javascript" src="js/popper.min.js"></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="js/mdb.min.js"></script>
<!-- Initializations -->
<script type="text/javascript">
  // Animations initialization
  new WOW().init();
</script>

</body>
</html>
