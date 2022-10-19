<?php
include 'C:\xampp\htdocs\AdminLTE-3.2.0\config.php';
session_start();
$id = $_SESSION['userid'];

if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>OVERFLOW</title>
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
        include('adminnavbar.php');
        ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="admin.php" class="brand-link">
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
                                <a href="#" class="d-block"> <?php echo htmlentities($result->firstname); ?> </a>
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
                            <a href="./admin.php" class="nav-link active">
                                <i class="nav-icon fas fa-home"></i>
                                <p>DASHBOARD</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="./users.php" class="nav-link">
                                <i class="nav-icon fas fa-users"></i>
                                <p>USERS</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="./usernotes.php" class="nav-link">
                                <i class="nav-icon far fa-sticky-note"></i>
                                <p>NOTES</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="./usersharednotes.php" class="nav-link">
                                <i class="nav-icon fas fa-sticky-note"></i>
                                <p>SHARED NOTES</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="./userfiles.php" class="nav-link">
                                <i class="nav-icon fas fa-file"></i>
                                <p>FILES</p>
                            </a>
                        </li>


                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Dashboard</h1>
                        </div><!-- /.col -->
                    </div><!-- /.container-fluid -->
                </div>
                <!-- /.content-header -->

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <!-- Info boxes -->
                        <div class="row">

                            <a href="users.php" class="col-12 col-sm-6 col-md-3">
                                <div>
                                    <div class="info-box">
                                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>

                                        <div class="info-box-content">
                                            <span class="info-box-text">Users</span>
                                            <?php
                                            $sql = "SELECT COUNT(*) AS total FROM user WHERE usertype !='admin'";
                                            $query = $dbh->prepare($sql);
                                            $query->execute();
                                            $results = $query->fetchALL(PDO::FETCH_OBJ);

                                            $cnt = 1;
                                            if ($query->rowCount() > 0) {
                                                # code...
                                                foreach ($results as $result) {
                                            ?>
                                                    <span class="info-box-number">
                                                        <?php echo htmlentities($result->total) ?>
                                                    </span>
                                            <?php }
                                            } ?>
                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                    <!-- /.info-box -->
                                </div>
                            </a>

                            <!-- /.col -->
                            <a href="usernotes.php" class="col-12 col-sm-6 col-md-3">
                                <div>
                                    <div class="info-box mb-3">
                                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-sticky-note"></i></span>

                                        <div class="info-box-content">
                                            <span class="info-box-text">Notes</span>
                                            <?php
                                            $sql = "SELECT COUNT(*) AS total FROM notes";
                                            $query = $dbh->prepare($sql);
                                            $query->execute();
                                            $results = $query->fetchALL(PDO::FETCH_OBJ);

                                            $cnt = 1;
                                            if ($query->rowCount() > 0) {
                                                # code...
                                                foreach ($results as $result) {
                                            ?>
                                                    <span class="info-box-number">
                                                        <?php echo htmlentities($result->total) ?>
                                                    </span>
                                            <?php }
                                            } ?>
                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                    <!-- /.info-box -->
                                </div>
                            </a>

                            <!-- /.col -->

                            <!-- fix for small devices only -->
                            <div class="clearfix hidden-md-up"></div>

                            <a href="usersharednotes.php" class="col-12 col-sm-6 col-md-3">
                                <div>
                                    <div class="info-box mb-3">
                                        <span class="info-box-icon bg-success elevation-1"><i class="far fa-sticky-note"></i></span>

                                        <div class="info-box-content">
                                            <span class="info-box-text">Shared Notes</span>
                                            <?php
                                            $sql = "SELECT COUNT(*) AS total FROM sharednotes";
                                            $query = $dbh->prepare($sql);
                                            $query->execute();
                                            $results = $query->fetchALL(PDO::FETCH_OBJ);

                                            $cnt = 1;
                                            if ($query->rowCount() > 0) {
                                                # code...
                                                foreach ($results as $result) {
                                            ?>
                                                    <span class="info-box-number">
                                                        <?php echo htmlentities($result->total) ?>
                                                    </span>
                                            <?php }
                                            } ?>
                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                    <!-- /.info-box -->
                                </div>
                            </a>

                            <!-- /.col -->
                            <a href="userfiles.php" class="col-12 col-sm-6 col-md-3">
                                <div>
                                    <div class="info-box mb-3">
                                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-file"></i></span>

                                        <div class="info-box-content">
                                            <span class="info-box-text">Files</span>
                                            <?php
                                            $sql = "SELECT COUNT(*) AS total FROM file";
                                            $query = $dbh->prepare($sql);
                                            $query->execute();
                                            $results = $query->fetchALL(PDO::FETCH_OBJ);

                                            $cnt = 1;
                                            if ($query->rowCount() > 0) {
                                                # code...
                                                foreach ($results as $result) {
                                            ?>
                                                    <span class="info-box-number">
                                                        <?php echo htmlentities($result->total) ?>
                                                    </span>
                                            <?php }
                                            } ?>
                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                    <!-- /.info-box -->
                                </div>
                            </a>

                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                        <!-- /.row -->
                    </div>
                    <!--/. container-fluid -->
                </section>
                <!-- /.content -->
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
    <script src="js/journalnotif.js"></script>
</body>

</html>