<?php
include 'D:\PROGRAMMING SOFTWARES\XAMPP\htdocs\Capstone\config.php';
session_start();
$id = $_SESSION['userid'];

if (!isset($_SESSION['userid'])) {
  header("Location: login.php");
}

if (isset($_POST['updateimage'])) {

  $image = $_FILES['image']['name'];

  $target_dir = "userimage/";
  $target_file = $target_dir . basename($_FILES["image"]["name"]);
  move_uploaded_file($_FILES['image']['tmp_name'], $target_dir . $image);

  $sql = "UPDATE user SET image=:image WHERE userid = $id";
  $query = $dbh->prepare($sql);
  $query->bindParam(':image', $image, PDO::PARAM_STR);
  $query->execute();
  header("Location: profile.php");
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
  <link rel="stylesheet" type="text/css" href="css/style2.css">
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
                <a href="#" class="d-block"> <?php echo htmlentities($result->firstname); ?> <?php echo htmlentities($result->lastname); ?></a>
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
              <a href="./index.php" class="nav-link">
                <i class="nav-icon fas fa-sticky-note"></i>
                <p>NOTES</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="./journal.php" class="nav-link">
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
              <div class="profile">
                <div class="firstdiv">
                  <div class="pic" style="display:flex; justify-content:center; align-items:center; gap:15px; ">
                    <?php
                    $sql = "SELECT * FROM user WHERE userid = $id";
                    $query = $dbh->prepare($sql);
                    $query->execute();
                    $results = $query->fetchALL(PDO::FETCH_OBJ);
                    foreach ($results as $result) {
                      $image = htmlentities($result->image);
                      if ($image == NULL) {
                    ?>

                        <img src="../dist/img/avatar.png" style="border-radius:50%;" alt="">
                      <?php } else {
                      ?>
                        <img src="userimage/<?php echo htmlentities($result->image) ?>" style="border-radius:50%; height:220px; width:220px;" alt="USER IMAGE">
                    <?php }
                    } ?>
                    <div>
                      <button data-toggle="modal" data-target="#updateimagemodal" style="background:transparent; color:white; border:none;"><i class="fas fa-edit"></i></button>
                    </div>

                  </div>
                  <div class="notecount" style="padding-top:25px;">

                    <div style="display: flex; justify-content:space-between;">
                      <div style="display: flex;flex-direction:column; ">
                        <label style="padding:7px;">Notes Made</label>
                        <?php
                        $sql = "SELECT COUNT(*) AS total FROM notes where userid = $id";
                        $query = $dbh->prepare($sql);
                        $query->execute();
                        $results = $query->fetchALL(PDO::FETCH_OBJ);
                        $cnt = 1;
                        if ($query->rowCount() > 0) {
                          # code...
                          foreach ($results as $result) {
                        ?>
                            <label style="padding-left:10px;"> <?php echo htmlentities($result->total); ?></label>
                        <?php }
                        } ?>

                      </div>
                      <div style="display: flex;flex-direction:column; ">
                        <label style="padding:7px;">Notes Shared</label>
                        <?php
                        $sql = "SELECT COUNT(DISTINCT notesid) AS total FROM sharednotes where ownerid = $id";
                        $query = $dbh->prepare($sql);
                        $query->execute();
                        $results = $query->fetchALL(PDO::FETCH_OBJ);
                        $cnt = 1;
                        if ($query->rowCount() > 0) {
                          # code...
                          foreach ($results as $result) {
                        ?>
                            <label style="padding-left:10px;"> <?php echo htmlentities($result->total); ?> </label>
                        <?php }
                        } ?>
                      </div>

                    </div>

                    <div style="display: flex;justify-content:space-between">
                      <div style="display: flex;flex-direction:column; ">
                        <label style="padding:7px;">Time Spent</label>
                        <?php
                        $sql = "SELECT * FROM time where userid = $id";
                        $query = $dbh->prepare($sql);
                        $query->execute();
                        $results = $query->fetchALL(PDO::FETCH_OBJ);
                        $cnt = 1;
                        if ($query->rowCount() > 0) {
                          # code...
                          foreach ($results as $result) {
                            $time = htmlentities($result->totaltime);
                            $time = strtotime($time);
                        ?>
                            <label style="padding-left:10px;"> <?php echo date('H', $time) ?> Hours <?php echo date('i', $time) ?> Minutes and <?php echo date('s', $time) ?> Seconds </label>
                        <?php }
                        } ?>
                      </div>

                      <div style="display: flex;flex-direction:column; ">
                        <label style="padding:7px 25px 7px 7px;">File Stored</label>
                        <?php
                        $sql = "SELECT COUNT(*) AS total FROM file where userid = $id";
                        $query = $dbh->prepare($sql);
                        $query->execute();
                        $results = $query->fetchALL(PDO::FETCH_OBJ);
                        $cnt = 1;
                        if ($query->rowCount() > 0) {
                          foreach ($results as $result) {
                        ?>
                            <label style="padding-left:10px;"> <?php echo htmlentities($result->total); ?> </label>
                        <?php }
                        } ?>
                      </div>

                    </div>




                  </div>
                </div>

                <div class="seconddiv">
                  <?php
                  $sql = "SELECT * FROM user WHERE userid = $id";
                  $query = $dbh->prepare($sql);
                  $query->execute();
                  $results = $query->fetchALL(PDO::FETCH_OBJ);
                  foreach ($results as $result) {
                  ?>
                    <div class="emailpass">
                      <label style="margin:5px;">EMAIL</label>
                      <input readonly type="text" class="form-control" aria-describedby="emailHelp" name="foldername" value="<?php echo htmlentities($result->email); ?>" disabled="disabled">
                      <label style="margin:5px;">PASSWORD</label>
                      <input readonly type="password" class="form-control" aria-describedby="emailHelp" name="password" value="<?php echo htmlentities($result->password); ?>" disabled="disabled">
                      <label style="margin:5px;">FIRSTNAME</label>
                      <input readonly type="text" class="form-control" aria-describedby="emailHelp" name="password" value="<?php echo htmlentities($result->firstname); ?>" disabled="disabled">
                      <label style="margin:5px;">LASTNAME</label>
                      <input readonly type="text" class="form-control" aria-describedby="emailHelp" name="password" value="<?php echo htmlentities($result->lastname); ?>" disabled="disabled">
                    </div>
                  <?php } ?>
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
  <div class="modal fade" id="updateimagemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Select Image</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
              <input type="file" class="form-control" name="image" id="exampleInputEmail1" aria-describedby="emailHelp" accept=".jpeg, .jpg, .png">
            </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" name="updateimage">Update</button>
          </form>
        </div>
      </div>
    </div>
  </div>
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