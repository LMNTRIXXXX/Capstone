<?php
include 'D:\PROGRAMMING SOFTWARES\XAMPP\htdocs\Capstone\config.php';
session_start();


$date = date('Y-m-d H:i:s');
if (!isset($_SESSION['userid'])) {
  header("Location: login.php");
}

if (isset($_POST['update'])) {

  $updateid = ($_POST['updateid']);
  $notescontent = ($_POST['notescontent']);


  $sql = "UPDATE notes SET notescontent=:notescontent WHERE notesid=:updateid";
  $query = $dbh->prepare($sql);
  $query->bindParam(':notescontent', $notescontent, PDO::PARAM_STR);
  $query->bindParam(':updateid', $updateid, PDO::PARAM_STR);
  $query->execute();
  header("Location: sharednotes.php");
}
include('notifs.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>OVERFLOW</title>




  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <link rel="stylesheet" type="text/css" href="css/style2.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">

  <link rel="stylesheet" href="summernote/summernote-bs4.css">

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
              <a href="./sharednotes.php" class="nav-link active">
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
              <div class="align-folder">
                <div class="notess" style="width:100%;">
                  <div class="alignss">
                    <h1>SHARED NOTES</h1>

                    <div class="cards-container">
                      <?php
                      $id = $_SESSION['userid'];
                      $sql = "SELECT * FROM sharednotes
              INNER JOIN notes ON sharednotes.notesid = notes.notesid
              WHERE sharednotes.shareduserid = $id";
                      $query = $dbh->prepare($sql);
                      $query->execute();
                      $results = $query->fetchALL(PDO::FETCH_OBJ);

                      $cnt = 1;
                      if ($query->rowCount() > 0) {
                        # code...
                        foreach ($results as $result) {
                      ?>
                          <form class="note-card" method="post" style="width: 300px;max-height: 200px;overflow:auto;">
                            <div class="note-header">
                              <div class="title">
                                <h1><?php echo htmlentities($result->notesname) ?></h1>
                              </div>
                              <div class="buttons">
                                <a data-toggle="modal" href="#myModal1<?php echo htmlentities($result->notesid); ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                              </div>
                            </div>

                            <div class="note-card-content">
                              <div style="pointer-events: none;">
                                <textarea class=" viewnote" name="content"><?php echo htmlentities($result->notescontent); ?></textarea>
                              </div>
                              <input type="hidden" name="notesid" value="<?php echo htmlentities($result->notesid) ?>">
                            </div>
                          </form>
                          <br>
                          <?php
                          include('sharednotesmodal.php');
                          ?>
                    </div>
                  <?php
                        }
                      } else {
                  ?>
                  <div style="margin-top: 10px;" class="warning"> <i class="fa-solid fa-face-sad-tear"></i> No Shared Notes Found! <i class="fa-solid fa-face-smile"></i></div>
                <?php
                      }
                ?>
                  </div>

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

  <!-- MODALS -->

  <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Add Folder</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="POST">
            <div class="form-group">
              <label for="exampleInputEmail1">Folder Name</label>
              <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Folder Name" name="foldername">
            </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" name="submit">Add</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!--Large Modal-->

  <!-- The Modal -->









  <!-- END MODALS -->


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
  <script src="js/journalnotif.js"></script>
  <script src="js/timemanagement.js"></script>

  <script src="summernote/summernote-bs4.js"></script>
  <script>
    $('.summernote').summernote({
      height: 300,
    });
    $('.viewnote').summernote({
      toolbar: false,
    });
  </script>

</body>

</html>