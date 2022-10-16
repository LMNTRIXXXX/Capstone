<?php
include 'C:\xampp\htdocs\AdminLTE-3.2.0\config.php';
session_start();
$id = $_SESSION['userid'];

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
              <a href="./draw.php" class="nav-link ">
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

  $sql = "SELECT * FROM notes WHERE userid = $id";
  $query = $dbh->prepare($sql);
  $query->execute();
  ?>
  <script>
    $(document).ready(function() {
      var calendar = $('#calendar').fullCalendar({
        editable: false,
        header: {
          left: 'prev,next today',
          center: 'title',
          right: 'month,agendaWeek,agendaDay'
        },
        events: [<?php $results = $query->fetchALL(PDO::FETCH_OBJ);
                  foreach ($results as $result) { ?> {
            id: '<?php echo htmlentities($result->notesid); ?>',
            title: ' <?php echo htmlentities($result->notesname); ?>',
            url: 'index.php?folderid=<?php echo htmlentities($result->folderid); ?>',
            start: '<?php echo htmlentities($result->reminddate); ?>',
          }, <?php
                  } ?>],
        selectable: true,
        selectHelper: true,
      });
    });
  </script>
  <script src="js/notif.js"></script>
  <script>
    var objXMLHttpRequest = new XMLHttpRequest();
    objXMLHttpRequest.open('GET', 'notifs.php');
    objXMLHttpRequest.send();
  </script>
  <script src="js/timemanagement.js"></script>
  <script src="js/journalnotif.js"></script>
</body>

</html>