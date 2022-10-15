<?php
include 'D:\PROGRAMMING SOFTWARES\XAMPP\htdocs\Capstone\config.php';
session_start();


date_default_timezone_set('Asia/Singapore');
$date = date('Y-m-d H:i:s');
if (!isset($_SESSION['userid'])) {
  header("Location: login.php");
}

if (!isset($_GET['folderid'])) {
  $folderid = null;
} else {
  $folderid = ($_GET['folderid']);
}

if (isset($_POST['submit'])) {
  $id = $_SESSION['userid'];
  $foldername = ($_POST['foldername']);

  $sql = "INSERT INTO folder(userid, foldername)VALUES($id, :foldername)";
  $query = $dbh->prepare($sql);
  $query->bindParam(':foldername', $foldername, PDO::PARAM_STR);
  $query->execute();
  header("Location: index.php");
}

if (isset($_POST['submits'])) {


  $folderid = ($_GET['folderid']);
  $id = $_SESSION['userid'];
  $notesname = ($_POST['notesname']);
  $notescontent = ($_POST['notescontent']);
  $date = date('Y-m-d H:i:s');
  $reminddate = ($_POST['reminddate']);

  $sql = "INSERT INTO notes(folderid, userid, notesname, notescontent, reminddate, date, status)VALUES($folderid, $id, :notesname, :notescontent, :reminddate, NOW(), 'To Do')";
  $query = $dbh->prepare($sql);
  $query->bindParam(':notesname', $notesname, PDO::PARAM_STR);
  $query->bindParam(':notescontent', $notescontent, PDO::PARAM_STR);
  $query->bindParam(':reminddate', $reminddate, PDO::PARAM_STR);
  $query->execute();
  header("Location: index.php?folderid=$folderid");
}

if (isset($_POST['update'])) {

  $updateid = ($_POST['updateid']);
  $notesname = ($_POST['notesname']);
  $notescontent = ($_POST['notescontent']);
  $folderid = ($_GET['folderid']);

  $sql = "UPDATE notes SET notesname=:notesname, notescontent=:notescontent WHERE notesid=:updateid";
  $query = $dbh->prepare($sql);
  $query->bindParam(':notesname', $notesname, PDO::PARAM_STR);
  $query->bindParam(':notescontent', $notescontent, PDO::PARAM_STR);
  $query->bindParam(':updateid', $updateid, PDO::PARAM_STR);
  $query->execute();
  header("Location: index.php?folderid=$folderid");
}

if (isset($_POST['delete'])) {

  $notesid = ($_POST['notesid']);

  $sql = "DELETE FROM notes WHERE notesid=:notesid";
  $query = $dbh->prepare($sql);
  $query->bindParam(':notesid', $notesid, PDO::PARAM_STR);
  $query->execute();
  header("Location: index.php?folderid=$folderid");
}

if (isset($_POST['share'])) {

  $id = $_SESSION['userid'];
  $notesid = ($_POST['notesid']);
  $shareduserid = ($_POST['sharedid']);
  $userfullname = $_SESSION['firstname'] . " " . $_SESSION['lastname'];

  $sql = "INSERT INTO sharednotes(ownerid, notesid, shareduserid, date)VALUES($id, :notesid, :shareduserid, NOW())";
  $query = $dbh->prepare($sql);
  $query->bindParam(':notesid', $notesid, PDO::PARAM_STR);
  $query->bindParam(':shareduserid', $shareduserid, PDO::PARAM_STR);
  $query->execute();

  $message = "$userfullname shared a note with you.";
  $header = "sharednotes.php";

  $sql1 = "INSERT INTO notification(receiverid, message, date, header)VALUES($shareduserid, '$message', NOW(), '$header')";
  $query1 = $dbh->prepare($sql1);
  $query1->execute();

  header("Location: index.php?folderid=$folderid");
}

if (isset($_POST['unshare'])) {
  $deleteid = ($_POST['deleteid']);
  $sql = "DELETE FROM sharednotes WHERE shareid=:deleteid";
  $query = $dbh->prepare($sql);
  $query->bindParam(':deleteid', $deleteid, PDO::PARAM_STR);
  $query->execute();
  header("Location: index.php?folderid=$folderid");
}

if (isset($_POST['readnotifs'])) {
  $deleteid = ($_POST['deleteid']);
  $sql = "DELETE FROM sharednotes WHERE shareid=:deleteid";
  $query = $dbh->prepare($sql);
  $query->bindParam(':deleteid', $deleteid, PDO::PARAM_STR);
  $query->execute();
  header("Location: index.php?folderid=$folderid");
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
              <a href="./index.php" class="nav-link active">
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
              <div class="align-folder">
                <div class="folder">
                  <div class="align">
                    <h1>Folders</h1> <button style="background-color:gray" data-toggle="modal" data-target="#exampleModalCenter"><i class="fa-solid fa-plus"></i></button>
                  </div>
                  <div class="folders">
                    <?php
                    $sql = "SELECT * FROM folder WHERE userid=$id";
                    $query = $dbh->prepare($sql);
                    $query->execute();
                    $results = $query->fetchALL(PDO::FETCH_OBJ);

                    $cnt = 1;
                    if ($query->rowCount() > 0) {
                      # code...
                      foreach ($results as $result) {
                    ?>
                        <a href="index.php?folderid=<?php echo htmlentities($result->folderid) ?>"><button class="folderbutton" type="button"><i class="fa-solid fa-folder" style="margin-right:10px; "></i> <?php echo htmlentities($result->foldername); ?></button></a>

                    <?php
                      }
                    }
                    ?>
                  </div>
                </div>
                <div class="notess">
                  <div class="aligns">
                    <h1>NOTES</h1>




                    <div class="btnss">
                      <?php if ($folderid != null) { ?>
                        <button style="background-color:gray" name="submit" data-toggle="modal" data-toggle="modal" data-target="#myModal"><i class="fa-solid fa-plus"></i></button>
                      <?php } ?>
                    </div>
                  </div>
                  <div class="note-items">
                    <?php
                    if ($folderid == null) {
                    ?>
                      <div class="warning"> <i class="fa-solid fa-face-sad-tear"></i> Select Folder <i class="fa-solid fa-face-smile"></i></div>
                      <?php
                    } else {

                      $sql = "SELECT * FROM notes
                          INNER JOIN folder ON notes.folderid = folder.folderid
                          WHERE notes.folderid=$folderid";
                      $query = $dbh->prepare($sql);
                      $query->execute();
                      $results = $query->fetchALL(PDO::FETCH_OBJ);

                      $cnt = 1;
                      if ($query->rowCount() > 0) {
                        foreach ($results as $result) {
                          $notesid = $result->notesid;
                      ?>
                          <form class="note-card" method="post">
                            <div class="note-header">
                              <div class="title">
                                <h1><?php echo htmlentities($result->notesname) ?></h1>
                              </div>
                              <div class="buttons">
                                <a data-toggle="modal" href="#myModal4<?php echo htmlentities($result->notesid); ?>" style="padding-right:7px;"><i class="fas fa-eye"></i></a>
                                <a data-toggle="modal" href="#myModal1<?php echo htmlentities($result->notesid); ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                                <button onclick="return confirm('Delete ?')" class="deletebutton" type="submit" name="delete"><i class="fa-solid fa-trash"></i></button>
                              </div>
                            </div>

                            <div class="note-card-content">
                              <p><?php echo htmlentities($result->notescontent) ?></p>
                              <input type="hidden" name="notesid" value="<?php echo htmlentities($result->notesid) ?>">
                            </div>
                          </form>


                          <?php
                          include('notes.php');
                          ?>

                  </div>

                  <section>
                    <div class="modal fade" id="myModal4<?php echo htmlentities($result->notesid); ?>">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          <!-- Modal Header -->
                          <div class="modal-header">
                            <h4 class="modal-title" style="color: #FFFFFF"><?php echo htmlentities($result->notesname); ?></h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                          </div>
                          <!-- Modal body -->
                          <form method="POST">
                            <div class="modal-body">
                              <div id="sample" style="color: white;">
                                <p style="letter-spacing: 0.8px;font-size:20px;"><?php echo htmlentities($result->notescontent); ?></p>
                              </div>
                            </div>

                            <!-- Modal footer -->
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                          </form>
                        </div>
                      </div>
                  </section>
                <?php
                        }
                      } else {
                ?>
                <div class="warning"> <i class="fa-solid fa-face-sad-tear"></i> No Notes Found! Make some <i class="fa-solid fa-face-smile"></i></div>
            <?php
                      }
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
  <div class="modal fade" id="myModal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Add Notes</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <form method="POST">
          <div class="modal-body" style="color:black;">
            <input type="text" class="form-control" placeholder="Notes Name" name="notesname" required style="color:black; background-color:white;">
            <br>
            <div style="background-color: #FFFFFF; color:black;">
              <script type="text/javascript" src="//js.nicedit.com/nicEdit-latest.js"></script>
              <script type="text/javascript">
                bkLib.onDomLoaded(function() {
                  nicEditors.allTextAreas()
                });
              </script>
              <textarea name="notescontent" style="width: 765px; height: 200px; padding: 20px;"></textarea>
            </div>
            <span style="color:white;">Remind Date:</span>
            <input type="date" class="form-control" placeholder="date" name="reminddate" style="color:black; background-color:white; margin-top:5px;">
          </div>
          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" name="submits">Add</button>
          </div>
      </div>
    </div>
  </div>









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

  <script>
    // var objXMLHttpRequest = new XMLHttpRequest();
    // objXMLHttpRequest.open('POST', 'notifs.php');
    // objXMLHttpRequest.send();

    (function() {
      setInterval(function() {
        $.ajax({
          async: true,
          type: 'POST',
          url: 'notifs.php',
        });
      }, 200);
    }());
  </script>
  <script src="js/timemanagement.js"></script>
</body>

</html>