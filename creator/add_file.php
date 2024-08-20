<!DOCTYPE html>
<html lang="en">
<?php
// Initialize session
session_start();
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
    <script src="js/jquery-1.8.3.min.js"></script>
    <link rel="stylesheet" type="text/css" href="medias/css/dataTable.css" />
    <script src="medias/js/jquery.dataTables.js" type="text/javascript"></script>
    <script type="text/javascript" charset="utf-8">
        $(document).ready(function(){
            $('#dtable').dataTable({
                "aLengthMenu": [[5, 10, 15, 25, 50, 100 , -1], [5, 10, 15, 25, 50, 100, "All"]],
                "iDisplayLength": 10
            });
        });
    </script>
    <style>
        .sidebar-fixed {
            width: 250px;
            height: 100%;
            position: fixed;
            background-color: white;
            color: white;
            padding-top: 40px;
            margin-top: 80px;
            border-right: 2px solid #00008B; /* Dark blue border */
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
        .navbar-custom {
            background-color: #002366;
        }
        .navbar-custom .navbar-brand img {
            height: 40px;
            margin-right: 10px;
            padding-left: 325px;
        }
        .navbar-custom .navbar-text {
            color:white;
            font-size: 1.2rem;
            font-weight: bold;
        }
    </style>
    <script src="jquery.min.js"></script>
    <script type="text/javascript">
        $(window).on('load', function(){
            //you remove this timeout
            setTimeout(function(){
                $('#loader').fadeOut('slow');  
            });
            //remove the timeout
            //$('#loader').fadeOut('slow'); 
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
                <ul class="navbar-nav mr-auto"></ul>
                <?php 
                require_once("include/connection.php");
                $id = mysqli_real_escape_string($conn,$_SESSION['admin_user']);
                $r = mysqli_query($conn,"SELECT * FROM admin_login where id = '$id'") or die (mysqli_error($conn));
                $row = mysqli_fetch_array($r);
                $id=$row['admin_user'];
                $admin_status=$row['admin_status'];
                $name=$row['name'];
                ?>
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
    <!-- Sidebar -->
    <div class="sidebar-fixed dark-blue-border">
        <a class="logo-wrapper waves-effect"></a>
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
<!--Main Navigation-->
<div id="loader"></div>
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
                <div class="d-flex justify-content-center pull-right">
                    <a href="add_document.php">
                        <button class="btn btn-warning"><i class="far fa-file-image"></i> View File</button>
                    </a>
                </div>
            </div>
            <hr>
            <div class="modal fade" id="modalRegisterForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header text-center">
                            <h4 class="modal-title w-100 font-weight-bold">Add File Form</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body mx-2"></div>
                    </div>
                </div>
            </div>
            <center>
                <div class="text-center col-md-5">
                    <div class="card">
                        <h5 class="card-header info-color white-text text-center py-4">
                            <strong>Upload File Form</strong>
                        </h5>
                        <div class="card-body px-lg-5 pt-0">
                            <div class="container">
                                <div class="row"><br><br>
                                    <form action="fileprocess.php" method="post" enctype="multipart/form-data" onsubmit="return validateForm();">
                                        <div class="col-md-11">
                                            <div class="md-form mb-0">
                                                <input type="hidden" name="email" value="<?php echo ucwords(htmlentities($name)); ?>" class="form-control" readonly="">
                                                <input type="text" value="<?php echo ucwords(htmlentities($admin_status)); ?>" class="form-control" readonly="">
                                            </div>
                                        </div>
                                        <div class="col-md-11">
                                            <div class="md-form mb-0">
                                                <select name="category" class="form-control" required>
                                                    <option value="">Select Category</option>
                                                    <option value="CAD">CAD</option>
                                                    <option value="Finance">Finance</option>
                                                    <option value="IT">IT</option>
                                                    <!-- Add more categories as needed -->
                                                </select>
                                            </div>
                                        </div>
                                        <label for="subject" class="">Upload File</label>
                                        <input type="file" name="myfile" required> <br>
                                        <button type="submit" class="btn btn-info btn-rounded btn-block my-4 waves-effect z-depth-0" name="save">UPLOAD</button>
                                        <footer style="font-size: 12px"><b>File Type:</b> pdf,docx,zip,png,jpeg,jpg <b>File Size:</b> 15MB</footer>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </center>
        </div>
    </div>
</main>
<!--Main layout-->
<!-- Footer -->
<footer class="page-footer text-center font-small primary-color-dark darken-2 mt-4 wow fadeIn">
    <hr class="my-4">
    <div class="pb-4"></div>
    <div class="footer-copyright py-3">
        © 2021 Copyright:
        <a href="https://mdbootstrap.com/education/bootstrap/" target="_blank"> Goa Shipyard Limited</a>
    </div>
</footer>
<!-- Footer -->
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

<script type="text/javascript">
   $("#Alert").on("click", function () {
          
          // userad();
          uservalidate();
          userfile();
   
         if (uservalidate() === true && userfile() === true) {
   
         };
   
   
   });
   
   //    function userad() {
   // if ($('#orangeForm-name').val() == '') { 
   //     $('#orangeForm-name').css('border-color', '#dc3545');
   //  return false;
   //   } else {
   //    $('#orangeForm-name').css('border-color', '#28a745'); 
   //     return true;
   // }

   function uservalidate() {
   if ($('#categ').val() == '') { 
       $('#categ').css('border-color', '#dc3545');
    return false;
     } else {
      $('#categ').css('border-color', '#dc3545'); 
       return true;
   }
   
   };

      function userfile() {
   if ($('#file').val() == '') { 
       $('#file').css('border-color', '#dc3545');
    return false;
     } else {
      $('#file').css('border-color', '#dc3545'); 
       return true;
   }
   
   };
   

   
   
</script>