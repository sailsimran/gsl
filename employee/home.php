<!DOCTYPE html>
<html lang="en">
<?php
session_start();
if(!isset($_SESSION["email_address"])){
    header("location:../login.html");
} 
?>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Home</title>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
  <!-- Bootstrap core CSS -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <!-- Material Design Bootstrap -->
  <link href="css/mdb.min.css" rel="stylesheet">
  <!-- Your custom styles (optional) -->
  <link href="css/style.css" rel="stylesheet">

  <!-- DataTables CSS & JS -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.9/css/jquery.dataTables.min.css"/>   
  <script src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/1.0.3/css/dataTables.responsive.css">
  <script src="https://cdn.datatables.net/responsive/1.0.3/js/dataTables.responsive.js"></script>
  
  <style>
    #loader {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: url('img/lg.flip-book-loader.gif') 50% 50% no-repeat rgb(249,249,249);
        opacity: 1;
    }
  </style>

  <script src="jquery.min.js"></script>
  <script type="text/javascript">
    $(window).on('load', function(){
      $('#loader').fadeOut('slow');  
    });

    $(document).ready(function(){
        $('#dtable').DataTable({
            "aLengthMenu": [[5, 10, 15, 25, 50, 100 , -1], [5, 10, 15, 25, 50, 100, "All"]],
            "iDisplayLength": 10
        });
    });

    function viewPDF(file_id) {
      $.ajax({
        url: 'fetch_pdf.php',
        type: 'GET',
        data: { file_id: file_id },
        success: function(response) {
          $('#pdfViewer').html(
            '<embed src="data:application/pdf;base64,' + btoa(response) + '" width="100%" height="600px" />'
          );
        },
        error: function() {
          alert('Failed to load PDF.');
        }
      });
    }
  </script>

</head>

<body style="padding:0px; margin:0px; background-color:#fff;font-family:arial,helvetica,sans-serif,verdana,'Open Sans'">
  <?php 
     require_once("include/connection.php");
     $id = mysqli_real_escape_string($conn,$_SESSION['email_address']);
     $r = mysqli_query($conn,"SELECT * FROM login_user where id = '$id'") or die (mysqli_error($conn));
     $row = mysqli_fetch_array($r);
     $id=$row['email_address'];
  ?>

  <!-- Navbar -->
  <nav class="mb-1 navbar navbar-expand-lg navbar-dark default-color fixed-top">
    <a class="navbar-brand" href="#">
      <img src="js/img/Files_Download.png" width="33px" height="33px">
      <font color="#F0B56F">F</font>ile <font color="#F0B56F">M</font>anagement <font color="#F0B56F">S</font>ystem
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
            <a class="dropdown-item" href="history_log.php"> <i class="fas fa-chalkboard-teacher"></i> User Logged</a>
            <a class="dropdown-item" href="Logout.php"><i class="fas fa-sign-in-alt"></i> LogOut</a>
          </div>
        </li>
      </ul>
    </div>
  </nav>
  <br><br><br>

  <!-- Main content -->
  <div class="container">
    <div class="row">
      <div class="col-md-9">
        <hr>
        <table id="dtable" class="table table-striped">
          <thead>
            <th>Filename</th>
            <th>FileSize</th>
            <th>Uploader</th>  
            <th>Status</th> 
            <th>Date/Time Upload</th>
            <th>Downloads</th>
            <th>Action</th>
          </thead>
          <tbody>
            <?php 
              require_once("include/connection.php");
              $query = mysqli_query($conn,"SELECT ID,NAME,SIZE,EMAIL,ADMIN_STATUS,TIMERS,DOWNLOAD FROM upload_files group by NAME DESC") or die (mysqli_error($conn));
              while($file=mysqli_fetch_array($query)){
                $id =  $file['ID'];
                $name =  $file['NAME'];
                $size =  $file['SIZE'];
                $uploads =  $file['EMAIL'];
                $status =  $file['ADMIN_STATUS'];
                $time =  $file['TIMERS'];
                $download =  $file['DOWNLOAD'];
            ?>
            <tr>
              <td width="17%"><?php echo  $name; ?></td>
              <td><?php echo floor($size / 1000) . ' KB'; ?></td>
              <td><?php echo $uploads; ?></td>
              <td><?php echo $status; ?></td>
              <td><?php echo $time; ?></td>
              <td><?php echo $download; ?></td>
              <td>
                <a href='downloads.php?file_id=<?php echo $id; ?>'><img src="img/698569-icon-57-document-download-128.png" width="30px" height="30px" title="Download File"></a>
                <a href='#' onclick='viewPDF(<?php echo $id; ?>)'><img src="img/view_icon.png" width="30px" height="30px" title="View File"></a>
              </td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
      
      <div class="col-md-3" style="border-top: 4px solid #17a2b8;border-radius: 4px;  box-shadow: 0px 1px 1px 0px  #6c757d;"><br>
        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab"
              aria-controls="pills-home" aria-selected="true">Profile</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab"
              aria-controls="pills-profile" aria-selected="false">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab"
              aria-controls="pills-contact" aria-selected="false">Contact</a>
          </li>
        </ul>
        <div class="tab-content pt-2 pl-1" id="pills-tabContent">
          <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
            <img src="img/nel.jpg" class="rounded" alt="..."><hr>
            <div class="">
              <div class=""><p><b style="font-size: 1.1em">Full Name:</b>CampCodes</p></div>
              <div class=""><p><b style="font-size: 1.1em">Role:</b>Administrator</p></div>
            </div>
          </div>
          <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
            <p>Sample paragraph for About section.</p>
          </div>
          <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
            <p>Sample paragraph for Contact section.</p>
          </div>
        </div>
      </div>
    </div>
    
    <!-- PDF Viewer Section -->
    <div class="row">
      <div class="col-md-12">
        <h3>PDF Viewer</h3>
        <div id="pdfViewer" style="border: 1px solid #ddd; padding: 10px; height: 600px;">
          <!-- PDF will be loaded here -->
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="page-footer text-center font-small primary-color-dark darken-2 mt-4 wow fadeIn">
    <!--Copyright-->
    <div class="footer-copyright py-3">
      © 2024 Copyright:
      <a href="#"> PCCE Students </a>
    </div>
    <!--/.Copyright-->
  </footer>

  <!-- SCRIPTS -->
  <!-- JQuery -->
  <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
  <!-- Bootstrap tooltips -->
  <script type="text/javascript" src="js/popper.min.js"></script>
  <!-- Bootstrap core JavaScript -->
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <!-- MDB core JavaScript -->
  <script type="text/javascript" src="js/mdb.min.js"></script>
</body>
</html>
