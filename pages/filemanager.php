<?php
include 'D:\PROGRAMMING SOFTWARES\XAMPP\htdocs\Capstone\config.php';
session_start();


$date = date('Y-m-d H:i:s');
if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
}



if (isset($_POST['add_file'])) {
    $id = $_SESSION['userid'];
    $filename = $_FILES['filename']['name'];
    $target_dir = "../files/";
    $target_file = $target_dir . basename($_FILES["filename"]["name"]);
    move_uploaded_file($_FILES['filename']['tmp_name'], $target_dir . $filename);

    $sql = "INSERT INTO file(userid, filename)VALUES($id, '$filename')";
    $query = $dbh->prepare($sql);
    $query->execute();
    header("Location: filemanager.php");
}
if (isset($_POST['delete_file'])) {

    $fileid = ($_POST['fileid']);
    $filename = ($_POST['filename']);

    $sql = "DELETE FROM file WHERE fileid=:fileid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':fileid', $fileid, PDO::PARAM_STR);
    $query->execute();
    unlink("../files/" . $filename);
    header("Location: filemanager.php");
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
                <img src="../dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
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
                            <a href="./filemanager.php" class="nav-link active">
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
                                        <div style="display: flex; justify-content:space-between;margin-bottom:20px;">
                                            <h1>FILES</h1>
                                            <div style="display: flex;gap:10px;">
                                                <form action="" method="GET" style="display: flex;">
                                                    <select style="width:200px;" class="form-control" name="selector" value="<?php if (isset($_GET['selector'])) ?>">
                                                        <option value="" disabled selected="" hidden>Select Filter</option>
                                                        <option>All</option>
                                                        <option>Documents</option>
                                                        <option>Excel</option>
                                                        <option>PDF</option>
                                                    </select>
                                                    <button style="width:70px; text-align:center; margin-left:10px; " type="submit" class="btn btn-primary">Filter</button>
                                                </form>
                                                <button style="background-color:gray" name="submit" data-toggle="modal" data-toggle="modal" data-target="#myModal"><i class="fa-solid fa-plus"></i></button>
                                            </div>
                                        </div>
                                        <div class="cards-container" style="display: flex;flex-direction:column; gap:4px;">
                                            <?php
                                            if (isset($_GET['selector'])) {

                                                $selector = $_GET['selector'];


                                                if ($selector == "Documents") {
                                                    $id = $_SESSION['userid'];
                                                    $sql = "SELECT * FROM file WHERE userid = $id AND filename LIKE '%.docx%'";
                                                    $query = $dbh->prepare($sql);
                                                    $query->execute();
                                                    $results = $query->fetchALL(PDO::FETCH_OBJ);
                                                } else if ($selector == "Excel") {
                                                    $id = $_SESSION['userid'];
                                                    $sql = "SELECT * FROM file WHERE userid = $id AND filename LIKE '%.xlsx%'";
                                                    $query = $dbh->prepare($sql);
                                                    $query->execute();
                                                    $results = $query->fetchALL(PDO::FETCH_OBJ);
                                                } else if ($selector == "PDF") {
                                                    $id = $_SESSION['userid'];
                                                    $sql = "SELECT * FROM file WHERE userid = $id AND filename LIKE '%.pdf%'";
                                                    $query = $dbh->prepare($sql);
                                                    $query->execute();
                                                    $results = $query->fetchALL(PDO::FETCH_OBJ);
                                                } else if ($selector == "All") {
                                                    $id = $_SESSION['userid'];
                                                    $sql = "SELECT * FROM file WHERE userid = $id";
                                                    $query = $dbh->prepare($sql);
                                                    $query->execute();
                                                    $results = $query->fetchALL(PDO::FETCH_OBJ);
                                                }

                                                if ($query->rowCount() > 0) {
                                                    foreach ($results as $result) {

                                            ?>


                                                        <div style="display: flex;justify-content:space-between;width:170px;">
                                                            <a href="../files/<?php echo htmlentities($result->filename); ?>" style="font-size:20px;margin-bottom:10px;width:150px;" download><?php echo htmlentities($result->filename); ?></a>
                                                            <form action="" method="post" style="margin-top:2px;">
                                                                <input type="hidden" name="fileid" value="<?php echo htmlentities($result->fileid); ?>">
                                                                <input type="hidden" name="filename" value="<?php echo htmlentities($result->filename); ?>">
                                                                <button onclick="return confirm('Delete ?')" type="submit" name="delete_file" style="background:transparent;border:none;"><i class="fas fa-trash"></i></button>
                                                            </form>

                                                        </div>

                                                    <?php }
                                                } else { ?>
                                                    <div style="margin-top: 10px;" class="warning"> <i class="fa-solid fa-face-sad-tear"></i> No File Found! <i class="fa-solid fa-face-smile"></i></div>
                                                    <?php
                                                }
                                            }
                                            if (!isset($_GET['selector'])) {
                                                $id = $_SESSION['userid'];
                                                $sql = "SELECT * FROM file WHERE userid = $id";
                                                $query = $dbh->prepare($sql);
                                                $query->execute();
                                                $results = $query->fetchALL(PDO::FETCH_OBJ);
                                                if ($query->rowCount() > 0) {
                                                    foreach ($results as $result) {

                                                    ?>
                                                        <div style="display: flex;justify-content:space-between;width:170px;">
                                                            <a href="../files/<?php echo htmlentities($result->filename); ?>" style="font-size:20px;margin-bottom:10px;width:150px;" download><?php echo htmlentities($result->filename); ?></a>
                                                            <form action="" method="post" style="margin-top:2px;">
                                                                <input type="hidden" name="fileid" value="<?php echo htmlentities($result->fileid); ?>">
                                                                <input type="hidden" name="filename" value="<?php echo htmlentities($result->filename); ?>">
                                                                <button onclick="return confirm('Delete ?')" type="submit" name="delete_file" style="background:transparent;border:none;"><i class="fas fa-trash"></i></button>
                                                            </form>
                                                        </div>
                                                    <?php }
                                                } else { ?>
                                                    <div style="margin-top: 10px;" class="warning"> <i class="fa-solid fa-face-sad-tear"></i> No File Found! <i class="fa-solid fa-face-smile"></i></div>
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

        <!--Large Modal-->

        <!-- The Modal -->


        <div class="modal fade" id="myModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">ADD FILE (pdf, xlsx, or docx)</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <form role="form" method="POST" enctype="multipart/form-data">
                        <div class="modal-body" style="color:black;">
                            <br>
                            <div style="background-color: #FFFFFF; color:black;">
                                <input type="file" name="filename" id="docpicker" accept=".doc,.docx,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,.pdf,.xlsx,.xls">
                            </div>
                        </div>
                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" name="add_file">Add</button>
                        </div>
                    </form>
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
            var objXMLHttpRequest = new XMLHttpRequest();
            objXMLHttpRequest.open('GET', 'notifs.php');
            objXMLHttpRequest.send();
        </script>
        <script src="js/timemanagement.js"></script>
</body>

</html>