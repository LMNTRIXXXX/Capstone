<?php
include 'D:\PROGRAMMING SOFTWARES\XAMPP\htdocs\Capstone\config.php';
session_start();


$date = date('Y-m-d H:i:s');
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

  <script src="https://cdn.ckeditor.com/4.19.1/standard/ckeditor.js"></script>



  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <link rel="stylesheet" type="text/css" href="css/draw.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
<script src="https://use.fontawesome.com/46af14eb3c.js"></script>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  
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
              <a href="./draw.php" class="nav-link active" >
              <i class="nav-icon fas fa-pencil-ruler"></i>
                  <p>DRAW</p>
                </a>
              </li>

              <li class="nav-item">
              <a href="./calendar.php" class="nav-link">
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
            

          <div class="draw-container">
      <section class="tools-board">
        <div class="row">
          <label class="title" style="color:black">Shapes</label>
          <ul class="options" style="padding-top:20px; margin-left:-40px;">
            <li class="option tool" id="rectangle">
              <img src="../icons/rectangle.svg" alt="">
              <span>Rectangle</span>
            </li>
            <li class="option tool" id="circle">
              <img src="../icons/circle.svg" alt="">
              <span>Circle</span>
            </li>
            <li class="option tool" id="triangle">
              <img src="../icons/triangle.svg" alt="">
              <span>Triangle</span>
            </li>
            <li class="option">
              <input type="checkbox" id="fill-color">
              <label for="fill-color">Fill color</label>
            </li>
          </ul>
        </div>
        <div class="row">
          <label class="title" style="color:black">Options</label>
          <ul class="options">
            <li class="option active tool" id="brush">
              <img src="icons/brush.svg" alt="">
              <span>Brush</span>
            </li>
            <li class="option tool" id="eraser">
              <img src="icons/eraser.svg" alt="">
              <span>Eraser</span>
            </li>
            <li class="option">
              <input type="range" id="size-slider" min="1" max="30" value="5">
            </li>
          </ul>
        </div>
        <div class="row colors">
          <label class="title" style="color:black">Colors</label>
          <ul class="options">
            <li class="option" ></li>
            <li class="option selected" ></li>
            <li class="option"></li>
            <li class="option"></li>
            <li class="option">
              <input type="color" id="color-picker" value="#4A98F7">
            </li>
          </ul>
        </div>
        <div class="row buttons">
          <button class="clear-canvas">Clear Canvas</button>
          <button class="save-img">Save As Image</button>
        </div>
      </section>
      <section class="drawing-board">
        <canvas></canvas>
      </section>
    </div>

          </div><!-- /.col -->
          </div>
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

<script src="js/draw.js"></script>
</script>
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
<script src="js/notif.js"></script> 
</body>
</html>
