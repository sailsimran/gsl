<!DOCTYPE html>
<html lang="en">
<?php
// Initialize session
session_start();

// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['admin_user'])) {
    header('Location: index.html');
}
?>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Material Design Bootstrap</title>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
  <!-- Bootstrap core CSS -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <!-- Material Design Bootstrap -->
  <link href="css/mdb.min.css" rel="stylesheet">
  <!-- Your custom styles (optional) -->
  <link href="css/style.min.css" rel="stylesheet">
  <!-- DataTables CSS -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
  <style>
    .navbar-custom {
        background-color: #002366; /* Blue color */
    }
    .navbar-custom .nav-link,
    .navbar-custom .navbar-brand,
    .navbar-custom .navbar-text {
        color: #fff;
    }
    .navbar-custom .nav-link .fa-user-circle {
        color: #fff;
    }
    .dark-blue-border {
        border: 2px solid #00008B;
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
    .sidebar-fixed {
    width: 250px;
    height: 100%;
    position: fixed;
    background-color: white;
    color: white;
    padding-top: 40px;
    margin-top: 80px;
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
    margin-bottom: 30px;
    padding: 10px;
    background: none;
}
.navbar-brand {
    display: flex;
    align-items: center;
    padding-left: 325px;
}

.navbar-brand img {
    height: 40px;
    margin-right: 10px;
}

.navbar-brand .navbar-text {
    font-size: 1.2rem;
    font-weight: bold;
    color: #fff;
}
  </style>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function(){
      $('#dtable').DataTable({
        "aLengthMenu": [[5, 10, 15, 25, 50, 100 , -1], [5, 10, 15, 25, 50, 100, "All"]],
        "iDisplayLength": 10
      });
    });

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
    <!-- Navbar -->
    <nav class="navbar fixed-top navbar-expand-lg navbar-light scrolling-navbar navbar-custom">
      <div class="container-fluid">
        <!-- Brand -->
        <a class="navbar-brand waves-effect" href="#">
          <img src="img/GSL.jpg" alt="GSL Logo" style="height: 40px; margin-right: 10px;">
          <span class="navbar-text">GOA SHIPYARD LIMITED</span>
        </a>

        <!-- Collapse -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Links -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <!-- Add any additional nav items here -->
          </ul>
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
    <!-- Sidebar -->
    <div class="sidebar-fixed dark-blue-border">
      <a class="logo-wrapper waves-effect"></a>
      <div class="list-group list-group-flush">
        <a href="dashboard.php" class="list-group-item active waves-effect">
          <i class="fas fa-chart-pie mr-3"></i> Dashboard
        </a>
        <a href="add_document.php" class="list-group-item list-group-item-action waves-effect">
          <i class="fas fa-file-medical"></i> Add Document
        </a>
      </div>
    </div>
    <!-- Sidebar -->

  </header>
  <!--Main Navigation-->

  <!--Main layout-->
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
      <div class="">
        <a href="add_file.php"><button type="button" class="btn btn-success"><i class="fas fa-file-medical"></i> Add File</button></a>
      </div>
      <hr>
      <div class="col-md-12">
        <table id="dtable" class="table table-striped">
          <thead>
            <th>Filename</th>
            <th>FileSize</th>
            <th>Uploader</th>
            <th>Status</th>   
            <th>Date/Time Upload</th>
            <th>Action</th>
          </thead>
          <tbody>
            <?php 
            require_once("include/connection.php");

            $query = mysqli_query($conn, "SELECT DISTINCT ID, NAME, SIZE, EMAIL, ADMIN_STATUS, TIMERS, DOWNLOAD FROM upload_files GROUP BY NAME DESC") or die (mysqli_error($conn));
            while ($file = mysqli_fetch_array($query)) {
              $id = $file['ID'];
              $name = $file['NAME'];
              $size = $file['SIZE'];
              $uploads = $file['EMAIL'];
              $status = $file['ADMIN_STATUS'];
              $time = $file['TIMERS'];
            ?>
            <tr>
              <td width="20%"><?php echo $name; ?></td>
              <td><?php echo floor($size / 1000) . ' KB'; ?></td>
              <td><?php echo $uploads; ?></td>
              <td><?php echo $status; ?></td>
              <td><?php echo $time; ?></td>
              <td>
                <!-- Remove the download button -->
                <a href='delete.php?ID=<?php echo $id; ?>' class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></a>
              </td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>  
      <!--Copyright-->
      <hr>
      <div class="footer-copyright py-3">
        <p>All right Reserved &copy; <?php echo date('Y');?> Created By: PCCE STUDENTS</p>
      </div>
      <!--/.Copyright-->
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
  <!-- DataTables JS -->
  <script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
</body>
</html>
