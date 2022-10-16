<?php
include 'C:\xampp\htdocs\AdminLTE-3.2.0\config.php';
session_start();
$id = $_SESSION['userid'];

if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
};
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

    <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

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
                                <a href="#" class="d-block"> <?php echo htmlentities($result->firstname); ?></a>
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
                            <a href="./admin.php" class="nav-link">
                                <i class="nav-icon fas fa-home"></i>
                                <p>DASHBOARD</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="./users.php" class="nav-link active">
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
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Users Table</h1>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">

                                        <thead>
                                            <tr>
                                                <th>Firstname</th>
                                                <th>Lastname</th>
                                                <th>Email</th>
                                                <th>Notes Made</th>
                                                <th>Shared Notes</th>
                                                <th>Time Spent</th>
                                                <th>File Stored</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            <?php
                                            $sql = "SELECT * FROM user WHERE usertype != 'admin'";
                                            $query = $dbh->prepare($sql);
                                            $query->execute();
                                            $results = $query->fetchALL(PDO::FETCH_OBJ);

                                            $cnt = 1;
                                            if ($query->rowCount() > 0) {
                                                # code...
                                                foreach ($results as $result) {
                                                    $userid = htmlentities($result->userid)
                                            ?>
                                                    <tr>
                                                        <td><?php echo htmlentities($result->firstname) ?></td>
                                                        <td><?php echo htmlentities($result->lastname) ?></td>
                                                        <td><?php echo htmlentities($result->email) ?></td>
                                                        <?php
                                                        $sql = "SELECT COUNT(*) AS total FROM notes where userid = $userid";
                                                        $query = $dbh->prepare($sql);
                                                        $query->execute();
                                                        $results = $query->fetchALL(PDO::FETCH_OBJ);
                                                        $cnt = 1;
                                                        if ($query->rowCount() > 0) {
                                                            # code...
                                                            foreach ($results as $result) {
                                                        ?>

                                                                <td style="text-align: center;"><?php echo htmlentities($result->total) ?></td>
                                                            <?php }
                                                        }
                                                        $sql = "SELECT COUNT(DISTINCT notesid) AS total FROM sharednotes where ownerid = $userid";
                                                        $query = $dbh->prepare($sql);
                                                        $query->execute();
                                                        $results = $query->fetchALL(PDO::FETCH_OBJ);
                                                        $cnt = 1;
                                                        if ($query->rowCount() > 0) {
                                                            # code...
                                                            foreach ($results as $result) {
                                                            ?>
                                                                <td style="text-align: center;"><?php echo htmlentities($result->total) ?></td>
                                                            <?php }
                                                        }
                                                        $sql = "SELECT * FROM time where userid = $userid";
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
                                                                <td><?php echo date('H', $time) ?> hrs <?php echo date('i', $time) ?> mins and <?php echo date('s', $time) ?> secs</td>
                                                            <?php }
                                                        } else { ?>
                                                            <td style="text-align: center;">0</td>
                                                            <?php }
                                                        $sql = "SELECT COUNT(*) AS total FROM file where userid = $userid";
                                                        $query = $dbh->prepare($sql);
                                                        $query->execute();
                                                        $results = $query->fetchALL(PDO::FETCH_OBJ);
                                                        $cnt = 1;
                                                        if ($query->rowCount() > 0) {
                                                            foreach ($results as $result) {
                                                            ?>

                                                                <td style="text-align: center;"><?php echo htmlentities($result->total) ?></td>
                                                        <?php }
                                                        } ?>
                                                    </tr>
                                            <?php }
                                            } ?>

                                        </tbody>
                                        
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </section>
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
    <!-- Bootstrap 4 -->
    <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables  & Plugins -->
    <script src="../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="../plugins/jszip/jszip.min.js"></script>
    <script src="../plugins/pdfmake/pdfmake.min.js"></script>
    <script src="../plugins/pdfmake/vfs_fonts.js"></script>
    <script src="../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="../plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <!-- Page specific script -->
    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
</body>

</html>