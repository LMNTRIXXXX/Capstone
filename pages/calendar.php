<?php
include 'D:\PROGRAMMING SOFTWARES\XAMPP\htdocs\Capstone\config.php';
session_start();
$id = $_SESSION['userid'];

if(!isset($_SESSION['userid'])){
  header("Location: login.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>OVERFLOW</title>
<script src="https://cdn.ckeditor.com/ckeditor5/35.0.1/classic/ckeditor.js"></script>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome Icons -->
<link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
<link rel="stylesheet" type="text/css" href="css/calendar.css">
<!-- overlayScrollbars -->
<link rel="stylesheet" href="../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="../dist/css/adminlte.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" integrity="sha512-KXkS7cFeWpYwcoXxyfOumLyRGXMp7BTMTjwrgjMg0+hls4thG2JGzRgQtRfnAuKTn2KWTDZX4UdPg+xTs8k80Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">

<!-- Preloader -->


<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
    <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
        <a href="index.php" class="nav-link">Home</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
    </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>

      <form class="readnotifs">
      <li class="nav-item dropdown" style="padding-right:20px;">
        <a class="nav-link" data-toggle="dropdown" type="submit" href="#">
          <i class="far fa-bell" id="bell"></i>
          <?php
          $id = $_SESSION['userid'];
          $sql="SELECT COUNT(*) AS total FROM notification where receiverid = $id AND status = 'unread'";
              $query=$dbh->prepare($sql);
              $query->execute();
              $results=$query->fetchALL(PDO::FETCH_OBJ);
              if ($query->rowCount()>0) {
                foreach ($results as $result) 
                {              
                if($result->total != 0)
                {
          ?>
          <span class="badge badge-danger navbar-badge"><?php echo htmlentities($result->total);?></span>
          <?php 
                }
              }
              }
          ?>
        </a>
        
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" >
          <div style="max-height:400px;overflow:auto">
          
          <!-- Message Start -->

          <?php 

          date_default_timezone_set('Asia/Singapore');
          function time_elapsed_string($datetime, $full = false) {
          $now = new DateTime;
          $ago = new DateTime($datetime);
          $diff = $now->diff($ago);

          $diff->w = floor($diff->d / 7);
          $diff->d -= $diff->w * 7;
  
          $string = array(
              'y' => 'year',
              'm' => 'month',
              'w' => 'week',
              'd' => 'day',
              'h' => 'hour',
              'i' => 'minute',
              's' => 'second',
          );
          foreach ($string as $k => &$v) {
              if ($diff->$k) {
                  $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
              } else {
                  unset($string[$k]);
              }
          }

          if (!$full) $string = array_slice($string, 0, 1);
          return $string ? implode(', ', $string) . ' ago' : 'just now';
          }
    
          $id = $_SESSION['userid'];
          $sql="SELECT * FROM notification WHERE receiverid = $id ORDER BY notifid DESC";
          $query=$dbh->prepare($sql);
          $query->execute();
          $results=$query->fetchALL(PDO::FETCH_OBJ);

          if ($query->rowCount()>0) {
          foreach ($results as $result) 
          {
          ?>
          
          <a href="<?php echo htmlentities($result->header);?>" class="dropdown-item">
            <div class="media">
              <div class="media-body">

                <p class="text-md"><?php echo htmlentities($result->message);?></p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i><?php echo time_elapsed_string(htmlentities($result->date));?></p>
              </div>
            </div>
          </a>
          <div class="dropdown-divider"></div>
          <?php
              }
          }
          else {
          ?>
            
            <div class="media" style="height:50px;">
              <div class="media-body" style="display:flex; justify-content:center; padding-top: 10px;">
                <p class="text-md" style="text-align:center;">No Notification</p>
              </div>
            </div>
  
          <div class="dropdown-divider"></div>
          <?php
          } 
          ?>
          <!-- Message End -->

          </div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
        </form>

      
      <li class="nav-item">
    <a href="logout.php"> <button class="material-symbols-outlined" style="padding-top: 6px; background-color:transparent; border:0; color:white;" >logout</button></a>
      </li>
      
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index.php" class="brand-link">
      <img src="../dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">OVERFLOW</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="../dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <?php
          $id = $_SESSION['userid'];
          $sql="SELECT * FROM user where userid = $id";
          $query=$dbh->prepare($sql);
          $query->execute();
          $results=$query->fetchALL(PDO::FETCH_OBJ);

          $cnt=1;
          if ($query->rowCount()>0) {
            # code...
            foreach ($results as $result) 
            {
          ?>
          <a href="profile.php" class="d-block"> <?php echo htmlentities($result->firstname);?> <?php echo htmlentities($result->lastname); ?></a>
          <?php } 
                    } ?>
        </div>
      </div>

      

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
              with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
            
            
              
          <li class="nav-item">
              <a href="./index.php" class="nav-link ">
              <i class="nav-icon fas fa-sticky-note"></i>
                  <p>NOTES</p>
                </a>
              </li>

              <li class="nav-item">
              <a href="./journal.php" class="nav-link ">
              <i class="nav-icon fas fa-book"></i>
                  <p>JOURNAL</p>
                </a>
              </li>

              <li class="nav-item">
              <a href="./sharednotes.php" class="nav-link ">
              <i class="nav-icon far fa-sticky-note"></i>
                  <p>SHARED NOTES</p>
                </a>
              </li>

              <li class="nav-item">
              <a href="./draw.php" class="nav-link " >
              <i class="nav-icon fas fa-pencil-ruler"></i>
                  <p>DRAW</p>
                </a>
              </li>

              <li class="nav-item">
              <a href="./calendar.php" class="nav-link active">
              <i class="nav-icon fas fa-calendar"></i>
                  <p>CALENDAR</p>
                </a>
              </li>
              
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <div id="calendar" style="background:white; color:black; width:950px; border-radius:7px; margin-left:5px;"></div>
          </div>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->


<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="../plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.js"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="../plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="../plugins/raphael/raphael.min.js"></script>
<script src="../plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="../plugins/jquery-mapael/maps/usa_states.min.js"></script>
<!-- ChartJS -->
<script src="../plugins/chart.js/Chart.min.js"></script>


<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="../dist/js/pages/dashboard2.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>

  <?php
      
      $sql="SELECT * FROM notes WHERE userid = $id";
       $query=$dbh->prepare($sql);
       $query->execute();
?>
  <script>
    $(document).ready(function() {
     var calendar = $('#calendar').fullCalendar({
      editable:false,
      header:{
       left:'prev,next today',
       center:'title',
       right:'month,agendaWeek,agendaDay'
      },
      events: [<?php $results=$query->fetchALL(PDO::FETCH_OBJ);
                 foreach ($results as $result) 
                 { ?>{ id : '<?php echo htmlentities($result->notesid);?>', 
                       title : ' <?php echo htmlentities($result->notesname);?>',
                       url: 'index.php?folderid=<?php echo htmlentities($result->folderid);?>',
                       start : '<?php echo htmlentities($result->reminddate);?>', }, <?php 
                } ?>],
      selectable:true,
      selectHelper:true,
    });
  });
</script>
<script src="js/notif.js"></script> 
</body>
</html>
