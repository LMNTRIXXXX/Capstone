<?php
include 'D:\PROGRAMMING SOFTWARES\XAMPP\htdocs\Capstone\config.php';
session_start();


$date = date('Y-m-d H:i:s');
if(!isset($_SESSION['userid'])){
  header("Location: login.php");
}

if(!isset($_GET['folderid'])){
  $folderid=null;
}
else{
  $folderid=($_GET['folderid']);
}

if(isset($_POST['submit'])) 
{
    $id = $_SESSION['userid'];
    $foldername =($_POST['foldername']);

    $sql = "INSERT INTO folder(userid, foldername)VALUES($id, :foldername)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':foldername', $foldername, PDO::PARAM_STR);
    $query->execute();
    header("Location: index.php");
}

if(isset($_POST['submits']))
{ 
  

  $folderid=($_GET['folderid']);
  $id = $_SESSION['userid'];
  $notesname = ($_POST['notesname']);
  $notescontent = ($_POST['notescontent']);
  $date = date('Y-m-d H:i:s');

  $sql = "INSERT INTO notes(folderid, userid, notesname, notescontent, date)VALUES($folderid, $id, :notesname, :notescontent, NOW())";
  $query = $dbh->prepare($sql);
  $query->bindParam(':notesname', $notesname, PDO::PARAM_STR);
  $query->bindParam(':notescontent', $notescontent, PDO::PARAM_STR);
  $query->execute();
  header("Location: index.php");
  
}

if (isset($_POST['update'])) 
{ 
  
  $updateid = ($_POST['updateid']);
  $notesname = ($_POST['notesname']);
  $notescontent = ($_POST['notescontent']);
  $folderid=($_GET['folderid']);

  $sql = "UPDATE notes SET notesname=:notesname, notescontent=:notescontent WHERE notesid=:updateid";
  $query = $dbh->prepare($sql);
  $query->bindParam(':notesname', $notesname, PDO::PARAM_STR);
  $query->bindParam(':notescontent', $notescontent, PDO::PARAM_STR);
  $query->bindParam(':updateid',$updateid,PDO::PARAM_STR);
  $query->execute();
  header("Location: index.php?folderid=$folderid");
}

if (isset($_POST['delete'])) 
{ 
  
  $notesid = ($_POST['notesid']);

  $sql = "DELETE FROM notes WHERE notesid=:notesid";
  $query = $dbh->prepare($sql);
  $query->bindParam(':notesid', $notesid, PDO::PARAM_STR);
  $query->execute();
  header("Location: index.php?folderid=$folderid");
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

  <link rel="stylesheet" type="text/css" href="style2.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  
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

      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  John Pierce
                  <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Nora Silvester
                  <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
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
      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">OVERFLOW</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
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
          <a href="#" class="d-block"> <?php echo htmlentities($result->firstname);?> <?php echo htmlentities($result->lastname); ?></a>
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
                  <p>NOTES</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./journal.php">
                  <p>JOURNAL</p>
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
                <div class="align"><h1>Folders</h1> <button style="background-color:gray" data-toggle="modal" data-target="#exampleModalCenter"><i class="fa-solid fa-plus" ></i></button></div>
                <div class="folders">
                  <?php
                  $sql = "SELECT * FROM folder WHERE userid=$id";
                  $query=$dbh->prepare($sql);
                  $query->execute();
                  $results=$query->fetchALL(PDO::FETCH_OBJ);

                  $cnt=1;
                  if ($query->rowCount()>0) {
                  # code...
                  foreach ($results as $result) 
                  {
                  ?>
                  <a href="index.php?folderid=<?php echo htmlentities($result->folderid)?>"><button class="folderbutton" type="button"><i class="fa-solid fa-folder"  style="margin-right:10px; "></i> <?php echo htmlentities($result->foldername);?></button></a>
                  
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
                <?php if($folderid != null) {?>
                <button style="background-color:gray" name="submit"data-toggle="modal" data-toggle="modal" data-target="#myModal"><i class="fa-solid fa-plus" ></i></button>
                <?php } ?>
                  </div>
              </div>
              <div class="note-items">
              <?php
              if($folderid == null){
              ?>
              <div class="warning"> <i class="fa-solid fa-face-sad-tear"></i> Select Folder <i class="fa-solid fa-face-smile"></i></div>
              <?php
              }
              else{
                
                $sql = "SELECT * FROM notes
                INNER JOIN folder ON notes.folderid = folder.folderid
                WHERE notes.folderid=$folderid";
                $query=$dbh->prepare($sql);
                $query->execute();
                $results=$query->fetchALL(PDO::FETCH_OBJ);

                $cnt=1;
                if ($query->rowCount()>0) {
                foreach ($results as $result)
                {
              ?>
              <form class="note-card" method="post">
              <div class="note-header">
                <div class="title">
                <h1><?php echo htmlentities($result->notesname)?></h1>
                </div>  
                <div class="buttons">
                <a data-toggle="modal" href="#myModal1<?php echo htmlentities($result->notesid); ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                <button onclick="return confirm('Delete ?')" class="deletebutton" type="submit" name="delete"><i class="fa-solid fa-trash"></i></button>
                </div>
              </div>
              
              <div class="note-card-content">
              <p><?php echo htmlentities($result->notescontent)?></p>
              <input type="hidden" name="notesid" value="<?php echo htmlentities($result->notesid)?>">
              </div>
                </form>
              <br>
                
              <?php 
              include('notes.php'); 
              ?> 
          </div>
          

              <?php
                }
              }
              else{            
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
          <textarea name="notescontent" style="width: 765px; height: 200px; padding: 20px;"></textarea>
          </div>
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
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="plugins/raphael/raphael.min.js"></script>
<script src="plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="plugins/jquery-mapael/maps/usa_states.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>



<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard2.js"></script>
</body>
</html>
