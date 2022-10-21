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

if (isset($_POST['submit'])) {
    $email = strtolower($_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM user where email=:email AND password =:password";
    $query = $dbh->prepare($sql);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':password', $password, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetch(PDO::FETCH_ASSOC);
    if ($query->rowCount() > 0) {
        $status = $results['emailstatus'];
        $email = $results['email'];
        if ($status != 0) {
            $updateid = $results['userid'];
            $usertype = $results['usertype'];
            date_default_timezone_set('Asia/Singapore');
            $currenttime = date("F j, Y H:i:s");

            $sql1 = "UPDATE user SET logindate = '$currenttime' WHERE userid = $updateid";
            $query1 = $dbh->prepare($sql1);
            $query1->execute();

            session_regenerate_id();
            $_SESSION['userid'] = $results['userid'];
            $_SESSION['lastname'] = $results['lastname'];
            $_SESSION['firstname'] = $results['firstname'];
            if ($usertype == 'user') {
                header("Location: index.php");
            } else {
                header("Location: admin.php");
            }
        } else {
            echo '<script>alert("This account has not been verified. An email was sent to ' . $email . ' ")</script>';
        }
    } else {
        echo '<script>alert("Wrong Email or Password")</script>';
    }
}


?>

<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale-1.0">

    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <title>Login Form</title>

</head>

<body>
    <div class="container">

        <form action="" method="POST" class="login-email">
            <a href="../index.php"><img src="../dist/img/overflowlgoo.jpg" alt="Logo" style="height:100px;margin-top:-40px;margin-left:120px;"></a>
            <p class="login-text" style="font-size: 2rem; font-weight:800;">Login</p>
            <div class="input-group">
                <input type="email" placeholder="Email" name="email" required>
            </div>
            <div class="input-group">
                <input type="password" placeholder="Password" name="password" required>
            </div>
            <div class="input-group">
                <button name="submit" class="btn">Login</button>
            </div>
            <p class="login-register-text">Don't have an account yet? <a href="register.php">Register Here!</a></p>
            <p class="login-register-text">Forgot your password? <a href="forgot-password.php">Click Here!</a></p>
        </form>
    </div>
</body>

</html>