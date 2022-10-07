<?php
include 'D:\PROGRAMMING SOFTWARES\XAMPP\htdocs\Capstone\config.php';
session_start();
$id = $_SESSION['userid'];

if (!isset($_SESSION['userid'])) {
  header("Location: login.php");
}
date_default_timezone_set('Asia/Singapore');
$date = date('F j, Y');
$date2 = date('Y-m-d');
$currenttime = date("H:i:s");
if (isset($_POST['add_journal'])) {

  $id = $_SESSION['userid'];
  $content = ($_POST['content']);

  $sql = "INSERT INTO journal(userid, content, date)VALUES($id, :content, NOW())";
  $query = $dbh->prepare($sql);
  $query->bindParam(':content', $content, PDO::PARAM_STR);
  $query->execute();
  header("Location: journal.php");
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" type="text/css" href="css/style2.css">
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
              <a href="./journal.php" class="nav-link active">
                <i class="nav-icon fas fa-book"></i>
                <p>JOURNAL</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="./sharednotes.php" class="nav-link">
                <i class="nav-icon far fa-sticky-note"></i>
                <p>SHARED NOTES</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="./draw.php" class="nav-link">
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
              <div class="align-folder">
                <div class="notess" style="width:100%;">
                  <div class="alignss">
                    <div style="display:flex; justify-content:space-between;">
                      <h1>JOURNAL</h1>
                      <?php
                      $id = $_SESSION['userid'];
                      $sql = "SELECT * FROM journal WHERE userid = $id && date = '$date2'";
                      $query = $dbh->prepare($sql);
                      $query->execute();
                      $results = $query->fetchALL(PDO::FETCH_OBJ);
                      $cnt = 1;
                      if ($query->rowCount() > 0) {
                      ?>

                      <?php

                      } else {
                      ?>
                        <button style="background-color:gray" name="submit" data-toggle="modal" data-toggle="modal" data-target="#myModal"><i class="fa-solid fa-plus"></i></button>
                      <?php } ?>
                    </div>
                    <div class="cards-container">

                      <?php
                      $id = $_SESSION['userid'];
                      $sql = "SELECT * FROM journal WHERE userid = $id ORDER BY journalid DESC ";
                      $query = $dbh->prepare($sql);
                      $query->execute();
                      $results = $query->fetchALL(PDO::FETCH_OBJ);

                      $cnt = 1;
                      if ($query->rowCount() > 0) {
                        # code...
                        foreach ($results as $result) {
                      ?>

                          <a data-toggle="modal" href="#journalModal<?php echo htmlentities($result->journalid); ?>" style="color:black;display:flex;">
                            <form class=" note-card" method="post" style="max-height:200px;min-height:100px;overflow:hidden;">
                              <div class="note-header">
                                <div class="title">
                                  <h6 style="font-weight:600;font-size:20px;"><?php echo htmlentities(date("F j, Y", strtotime($result->date))) ?></h6>
                                </div>
                              </div>
                              <div class="note-card-content">
                                <p><?php echo htmlentities($result->content) ?></p>
                                <input type="hidden" name="notesid" value="test">
                              </div>
                            </form>
                          </a>

                          <?php
                          include('journalModal.php');
                          ?>
                    </div>

                  <?php
                        }
                      } else {
                  ?>
                  <div style="margin-top: 10px;" class="warning"> <i class="fa-solid fa-face-sad-tear"></i> No Journal Found! Make some <i class="fa-solid fa-face-smile"></i></div>
                <?php } ?>
                <br>
                  </div>




                </div>
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

  <!-- The Modal -->
  <div class="modal fade" id="myModal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Journal for <?php echo $date ?></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <form method="POST">
          <div class="modal-body" style="color:black;">
            <br>
            <div style="background-color: #FFFFFF; color:black;">
              <textarea name="content" style="width: 765px; height: 200px; padding: 20px;"></textarea>
            </div>
          </div>
          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" name="add_journal">Add</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- END MODALS -->

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
  <script>
    var objXMLHttpRequest = new XMLHttpRequest();
    objXMLHttpRequest.open('GET', 'notifs.php');
    objXMLHttpRequest.send();
  </script>
  <script src="js/timemanagement.js"></script>
</body>

</html>