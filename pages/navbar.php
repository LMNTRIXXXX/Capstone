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
        <form class="readnotifs">
            <li class="nav-item dropdown" style="padding-right:20px;">
                <a class="nav-link" data-toggle="dropdown" type="submit" href="#">
                    <i class="far fa-bell" id="bell"></i>
                    <?php
                    $id = $_SESSION['userid'];
                    $sql = "SELECT COUNT(*) AS total FROM notification where receiverid = $id AND status = 'unread'";
                    $query = $dbh->prepare($sql);
                    $query->execute();
                    $results = $query->fetchALL(PDO::FETCH_OBJ);
                    if ($query->rowCount() > 0) {
                        foreach ($results as $result) {
                            if ($result->total != 0) {
                    ?>
                                <span class="badge badge-danger navbar-badge"><?php echo htmlentities($result->total); ?></span>
                    <?php
                            }
                        }
                    }
                    ?>
                </a>

                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <div style="max-height:400px;overflow:auto">

                        <!-- Message Start -->

                        <?php

                        date_default_timezone_set('Asia/Singapore');
                        function time_elapsed_string($datetime, $full = false)
                        {
                            $now = new DateTime;
                            $ago = new DateTime($datetime);
                            $diff = $now->diff($ago);

                            $diff->w = floor($diff->d / 7);
                            $diff->d -= $diff->w * 7;

                            $string = array(
                                'y' => 'year',
                                'm' => 'month',
                                'w' => 'week',
                                'd' => 'day',
                                'h' => 'hour',
                                'i' => 'minute',
                                's' => 'second',
                            );
                            foreach ($string as $k => &$v) {
                                if ($diff->$k) {
                                    $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
                                } else {
                                    unset($string[$k]);
                                }
                            }

                            if (!$full) $string = array_slice($string, 0, 1);
                            return $string ? implode(', ', $string) . ' ago' : 'just now';
                        }

                        $id = $_SESSION['userid'];
                        $sql = "SELECT * FROM notification WHERE receiverid = $id ORDER BY notifid DESC";
                        $query = $dbh->prepare($sql);
                        $query->execute();
                        $results = $query->fetchALL(PDO::FETCH_OBJ);

                        if ($query->rowCount() > 0) {
                            foreach ($results as $result) {
                        ?>

                                <a href="<?php echo htmlentities($result->header); ?>" class="dropdown-item">
                                    <div class="media">
                                        <div class="media-body">

                                            <p class="text-md"><?php echo htmlentities($result->message); ?></p>
                                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i><?php echo time_elapsed_string(htmlentities($result->date)); ?></p>
                                        </div>
                                    </div>
                                </a>
                                <div class="dropdown-divider"></div>
                            <?php
                            }
                        } else {
                            ?>

                            <div class="media" style="height:50px;">
                                <div class="media-body" style="display:flex; justify-content:center; padding-top: 10px;">
                                    <p class="text-md" style="text-align:center;">No Notification</p>
                                </div>
                            </div>

                            <div class="dropdown-divider"></div>
                        <?php
                        }
                        ?>
                        <!-- Message End -->

                    </div>
                    <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                </div>
            </li>
        </form>

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