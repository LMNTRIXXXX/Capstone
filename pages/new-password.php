<?php
include 'D:\PROGRAMMING SOFTWARES\XAMPP\htdocs\Capstone\config.php';

session_start();
if (isset($_SESSION['userid'])) {
    if ($_GET['usertype'] = "admin") {
        header("Location: admin.php");
    } else {
        header("Location: index.php");
    }
}

if (isset($_GET['vkey'])) {

    $vkey = $_GET['vkey'];

    $sql = "SELECT vkey FROM user WHERE  vkey = '" . $vkey . "' ";
    $query = $dbh->prepare($sql);
    $query->execute();

    if ($query->rowCount() <= 0) {
        echo '<script>alert("Password reset link is invalid!")</script>';
        echo "<script type ='text/javascript'> document.location.href='login.php' </script>";
    }
}
if (!isset($_GET['vkey'])) {
    echo "<script type ='text/javascript'> document.location.href='login.php' </script>";
}

if (isset($_POST['submit'])) {

    $vkey = $_GET['vkey'];
    $password = ($_POST['password']);
    $newvkey = md5(time() . $password);

    $sql = "SELECT * FROM user WHERE  vkey = '" . $vkey . "' ";
    $query = $dbh->prepare($sql);
    $query->execute();
    $results = $query->fetch(PDO::FETCH_ASSOC);

    $emailstatus = $results['emailstatus'];

    if ($query->rowCount() > 0) {
        if ($emailstatus == 0) {
            $sql = "UPDATE user SET password=:password WHERE vkey = '" . $vkey . "'";
            $query = $dbh->prepare($sql);
            $query->bindParam(':password', $password, PDO::PARAM_STR);
            $query->execute();
            echo '<script>alert("Password was change successfully!")</script>';
            echo "<script type ='text/javascript'> document.location.href='login.php' </script>";
        } else {
            $sql = "UPDATE user SET password=:password, vkey = '" . $newvkey . "' WHERE vkey = '" . $vkey . "'";
            $query = $dbh->prepare($sql);
            $query->bindParam(':password', $password, PDO::PARAM_STR);
            $query->execute();
            echo '<script>alert("Password was change successfully!")</script>';
            echo "<script type ='text/javascript'> document.location.href='login.php' </script>";
        }
    }
}



?>

<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale-1.0">

    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <title>New Password</title>

</head>

<body>
    <div class="container">

        <form action="" method="POST" class="login-email">
            <a href="../index.php"><img src="../dist/img/overflowlgoo.jpg" alt="Logo" style="height:100px;margin-top:-40px;margin-left:120px;"></a>
            <p class="login-text" style="font-size: 2rem; font-weight:800;">New Password</p>
            <div class="input-group">
                <input type="password" placeholder="New password" name="password" required>
            </div>
            <div class="input-group">
                <button name="submit" class="btn">Submit</button>
            </div>
            <p class="login-register-text" style="padding-left: 150px;"><a href="login.php">Cancel!</a></p>
        </form>
    </div>
</body>

</html>