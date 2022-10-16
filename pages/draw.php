<?php
include 'C:\xampp\htdocs\AdminLTE-3.2.0\config.php';
session_start();


$date = date('Y-m-d H:i:s');
if (!isset($_SESSION['userid'])) {
  header("Location: login.php");
}

include('notifs.php');
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
    <?php
    include('navbar.php');
    ?>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="index.php" class="brand-link">
        <img src="../dist/img/overflowlgoo.jpg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">OVERFLOW</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <?php
            $sql = "SELECT * FROM user WHERE userid = $id";
            $query = $dbh->prepare($sql);
            $query->execute();
            $results = $query->fetchALL(PDO::FETCH_OBJ);
            foreach ($results as $result) {
              $image = htmlentities($result->image);
              if ($image == NULL) {
            ?>
                <img src="../dist/img/avatar.png" class="img-circle elevation-2" alt="USER IMAGE">
              <?php } else { ?>
                <img src="userimage/<?php echo htmlentities($result->image) ?>" style="width:33.6px; height:33.6px" class="img-circle elevation-2" alt="USER IMAGE">
            <?php }
            } ?>
          </div>
          <div class="info">
            <?php
            $id = $_SESSION['userid'];
            $sql = "SELECT * FROM user where userid = $id";
            $query = $dbh->prepare($sql);
            $query->execute();
            $results = $query->fetchALL(PDO::FETCH_OBJ);

            $cnt = 1;
            if ($query->rowCount() > 0) {
              # code...
              foreach ($results as $result) {
            ?>
                <a href="profile.php" class="d-block"> <?php echo htmlentities($result->firstname); ?> <?php echo htmlentities($result->lastname); ?></a>
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
              <a href="./draw.php" class="nav-link active">
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

            <li class="nav-item">
              <a href="./filemanager.php" class="nav-link">
                <i class="nav-icon fas fa-file"></i>
                <p>FILE MANAGER</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="./chat.php" class="nav-link">
                <i class="nav-icon fas fa-envelope"></i>
                <p>CHAT</p>
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
                      <li class="option"></li>
                      <li class="option selected"></li>
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
  <script src="js/timemanagement.js"></script>
  <script src="js/journalnotif.js"></script>
</body>

</html>