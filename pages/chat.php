<?php
include 'D:\PROGRAMMING SOFTWARES\XAMPP\htdocs\Capstone\config.php';
session_start();


date_default_timezone_set('Asia/Singapore');
$date = date('Y-m-d H:i:s');
if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
}
if (!isset($_GET['userid']) && !isset($_GET['yourid'])) {
    $yourID = null;
    $userID = null;
} else {
    $yourID = ($_GET['yourid']);
    $userID = ($_GET['userid']);
}

if (isset($_POST['readnotifs'])) {
    $deleteid = ($_POST['deleteid']);
    $sql = "DELETE FROM sharednotes WHERE shareid=:deleteid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':deleteid', $deleteid, PDO::PARAM_STR);
    $query->execute();
    header("Location: index.php?folderid=$folderid");
}
if (isset($_POST['send_message'])) {
    $message = ($_POST['message']);
    $senderid = ($_POST['senderid']);
    $receiverid = ($_POST['receiverid']);
    $sql = "INSERT INTO message(senderid, receiverid, message)VALUES(:senderid, :receiverid, :message)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':senderid', $senderid, PDO::PARAM_STR);
    $query->bindParam(':receiverid', $receiverid, PDO::PARAM_STR);
    $query->bindParam(':message', $message, PDO::PARAM_STR);
    $query->execute();
    header("Location: chat.php?yourid=$senderid&userid=$receiverid");
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
                            <a href="./chat.php" class="nav-link active">
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
                                        <h1 style="padding-left:10px;">Chats</h1> <button style="background-color:gray" data-toggle="modal" data-target="#chatModal"><i class="fa-solid fa-plus"></i></button>
                                    </div>
                                    <div class="folders">
                                        <?php

                                        $id = $_SESSION['userid'];
                                        $sql = "SELECT * FROM message 
                                        INNER JOIN user ON (message.receiverid = user.userid) OR  (message.senderid = user.userid) 
                                        WHERE (senderid = $id OR receiverid = $id) AND userid != $id GROUP BY userid";
                                        $query = $dbh->prepare($sql);
                                        $query->execute();
                                        $results = $query->fetchALL(PDO::FETCH_OBJ);
                                        if ($query->rowCount() > 0) {
                                            foreach ($results as $result) {
                                                $image = htmlentities($result->image);
                                                if ($image == NULL) {

                                        ?>
                                                    <a href="chat.php?yourid=<?php echo $id ?>&userid=<?php echo htmlentities($result->userid); ?>"><button class="folderbutton" type="button"><img src="../dist/img/avatar.png" style="width:30px; height:30px; border-radius:50%; margin-right:10px;" alt="userimage"> <?php echo htmlentities(ucfirst($result->firstname)); ?> <?php echo htmlentities(ucfirst($result->lastname)); ?> </button></a>
                                                <?php } else { ?>
                                                    <a href="chat.php?yourid=<?php echo $id ?>&userid=<?php echo htmlentities($result->userid); ?>"><button class="folderbutton" type="button"><img src="userimage/<?php echo htmlentities($result->image) ?>" style="width:30px; height:30px; border-radius:50%; margin-right:10px;" alt="userimage"> <?php echo htmlentities(ucfirst($result->firstname)); ?> <?php echo htmlentities(ucfirst($result->lastname)); ?> </button></a>
                                            <?php }
                                            }
                                        } else { ?>
                                            <div class="warning" style="font-size: 20px;"></i>
                                                <p>No contacts</p></i>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="notess">
                                    <div class="aligns">
                                        <div class="btnss">
                                        </div>
                                    </div>
                                    <div class="chat-items">
                                        <?php
                                        if ($userID == null && $yourID == null) {
                                        ?>
                                            <div class="warning"> <i class="fa-solid fa-face-sad-tear"></i> Select User to chat <i class="fa-solid fa-face-smile"></i></div>
                                        <?php
                                        } else { ?>
                                            <div class="chat-header">
                                                <?php
                                                $sql = "SELECT * FROM user WHERE userid = $userID";
                                                $query = $dbh->prepare($sql);
                                                $query->execute();
                                                $results = $query->fetchALL(PDO::FETCH_OBJ);
                                                foreach ($results as $result) {
                                                    $image = htmlentities($result->image);
                                                    if ($image == NULL) {
                                                ?>
                                                        <img src="../dist/img/avatar.png" class="img-circle elevation-2" alt="USER IMAGE">
                                                        <h3> <?php echo htmlentities(ucfirst($result->firstname)); ?> <?php echo htmlentities(ucfirst($result->lastname)); ?> </h3>
                                                    <?php } else {
                                                    ?>
                                                        <img src="userimage/<?php echo htmlentities($result->image) ?>" class="img-circle elevation-2" alt="USER IMAGE">
                                                        <h3> <?php echo htmlentities(ucfirst($result->firstname)); ?> <?php echo htmlentities(ucfirst($result->lastname)); ?> </h3>
                                                <?php }
                                                } ?>
                                            </div>
                                            <div class="chats" id="scroll">
                                                <?php
                                                $id = $_SESSION['userid'];
                                                $sql = "SELECT * FROM message WHERE (receiverid = $id OR senderid = $id) AND (receiverid = $userID OR senderid = $userID)";
                                                $query = $dbh->prepare($sql);
                                                $query->execute();
                                                $results = $query->fetchALL(PDO::FETCH_OBJ);
                                                if ($query->rowCount() > 0) {
                                                    foreach ($results as $result) {
                                                        $senderID = htmlentities($result->senderid);
                                                        if ($senderID == $id) {
                                                ?>
                                                            <div style="display: flex; justify-content:end;">
                                                                <div class="mymessage">
                                                                    <p> <?php echo htmlentities($result->message); ?> </p>
                                                                </div>
                                                            </div>
                                                        <?php } else { ?>

                                                            <div style="display: flex;">
                                                                <div class="receivedmessage">
                                                                    <p> <?php echo htmlentities($result->message); ?></p>
                                                                </div>
                                                            </div>
                                                    <?php
                                                        }
                                                    }
                                                } else {
                                                    ?>
                                                    <div class="warning"> <i class="fa-solid fa-face-sad-tear"></i> Say hi to start conversation <i class="fa-solid fa-face-smile"></i></div>
                                                <?php } ?>
                                            </div>
                                            <div>
                                                <form action="" method="post" class="send">
                                                    <input type="text" name="message" placeholder="Type something..." required>
                                                    <input type="hidden" name="senderid" value="<?php echo $yourID ?>">
                                                    <input type="hidden" name="receiverid" value="<?php echo $userID ?>">
                                                    <button type="submit" name="send_message"><i class="fas fa-paper-plane"></i></button>
                                                </form>
                                            </div>
                                    </div>
                                <?php } ?>

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

    <div class="modal fade" id="chatModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" style="color: #FFFFFF" id="exampleModalLongTitle">Select User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="user-container">


                        <?php
                        $id = $_SESSION['userid'];
                        $sql = "SELECT * FROM user
                        WHERE userid != $id AND usertype != 'admin'";
                        $query = $dbh->prepare($sql);
                        $query->execute();
                        $results = $query->fetchALL(PDO::FETCH_OBJ);
                        foreach ($results as $result) {
                        ?>
                            <form method="post">
                                <div class="user-items">
                                    <h4> <?php echo htmlentities($result->firstname); ?> <?php echo htmlentities($result->lastname); ?> </h4>

                                    <a href="chat.php?yourid=<?php echo $id ?>&userid=<?php echo htmlentities($result->userid); ?>" class="btn btn-success">Chat</a>

                                </div>
                            </form>
                        <?php } ?>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>>
    </div>

    <!--Large Modal-->










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
    <script src="js/journalnotif.js"></script>
    <script>
        var scroll = document.getElementById("scroll");
        scroll.scrollTop = scroll.scrollHeight;
    </script>
</body>

</html>