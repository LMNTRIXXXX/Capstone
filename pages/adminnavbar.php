<?php
if (isset($_POST['time'])) {
    $id = $_SESSION['userid'];
    $sql = "SELECT * FROM time WHERE userid = $id";
    $query = $dbh->prepare($sql);
    $query->execute();
    $results = $query->fetchALL(PDO::FETCH_OBJ);
    if ($query->rowCount() > 0) {
        foreach ($results as $result) {
            $updateid = htmlentities($result->timeid);
            $time = htmlentities($result->totaltime);

            $totaltime = ($_POST['totaltime']);
            $totaltime1 = strtotime($totaltime);
            $totaltime2 = date('H:i:s', $totaltime1);
            $totaltime3 = strtotime($time);
            $totaltime4 = date('H:i:s', $totaltime3);


            $secs = strtotime($totaltime4) - strtotime("00:00:00");
            $result = date("H:i:s", strtotime($totaltime2) + $secs);



            $sql1 = "UPDATE time SET totaltime = '$result' WHERE timeid = $updateid";
            $query1 = $dbh->prepare($sql1);
            $query1->execute();
            header("Location: logout.php");
        }
    } else {
        $id = $_SESSION['userid'];
        $totaltime = ($_POST['totaltime']);
        $totaltime1 = strtotime($totaltime);
        $totaltime2 = date('H:i:s', $totaltime1);

        $sql = "INSERT INTO time(userid, totaltime)VALUES($id, '$totaltime2')";
        $query = $dbh->prepare($sql);
        $query->execute();
        header("Location: logout.php");
    }
}
?>

<nav class="main-header navbar navbar-expand navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->
        <li class="nav-item">
            <div class="navbar-search-block">
                <form class="form-inline">
                    <div class="input-group input-group-sm">
                        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>

        <li class="nav-item">
            <form action="" method="post">
                <?php
                $id = $_SESSION['userid'];
                $sql = "SELECT * FROM user WHERE userid = $id";
                $query = $dbh->prepare($sql);
                $query->execute();
                $results = $query->fetchALL(PDO::FETCH_OBJ);
                if ($query->rowCount() > 0) {
                    foreach ($results as $result) {
                ?>

                        <h1 style="display:none;" id="logintime"><?php echo htmlentities($result->logindate) ?></h1>

                <?php }
                }
                ?>
                <input type="hidden" id="demo" name="totaltime">
                <button class="material-symbols-outlined" type="submit" name="time" style="padding-top: 6px; background-color:transparent; border:0; color:white;">logout</button>
            </form>
        </li>

    </ul>
</nav>