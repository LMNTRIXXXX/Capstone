<?php
include 'C:\xampp\htdocs\AdminLTE-3.2.0\config.php';
session_start();

if(isset($_SESSION['userid'])){
    header("Location: index.php");
}

if(isset($_POST['submit']))
{
    $firstname = strtoupper ($_POST['firstname']);
    $lastname = strtoupper ($_POST['lastname']);
    $email = strtolower ($_POST['email']);
    $password = md5 ($_POST['password']);

    $sql = "INSERT INTO user(firstname, lastname, email, password, usertype)VALUES(:firstname, :lastname, :email, :password, 'user')";
    $query = $dbh->prepare($sql);
    $query->bindParam(':firstname', $firstname, PDO::PARAM_STR);
    $query->bindParam(':lastname', $lastname, PDO::PARAM_STR);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':password', $password, PDO::PARAM_STR);
    $query->execute();
    header("Location: login.php");

}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale-1.0">

        <link rel="stylesheet" type="text/css" href="style.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

        <title>Register Form</title>

    </head>
    <body>
        <div class="container">
            
            <form action="" method="POST" class="login-email">
                <p class="login-text" style="font-size: 2rem; font-weight:800;">Register</p>
                <div class="input-group">
                    <input type="text" placeholder="Firstname" name="firstname"  required>
                </div>
                <div class="input-group">
                    <input type="text" placeholder="Lastname" name="lastname"  required>
                </div>
                <div class="input-group">
                    <input type="email" placeholder="Email" name="email"  required>
                </div>
                <div class="input-group">
                    <input type="password" placeholder="Password" name="password"  required>
                </div>
                <div class="input-group">
                    <button name="submit" class="btn">Register</button>
                </div>
                <p class="login-register-text">Have an account yet? <a href="login.php">Login Here!</a></p>
            </form>
        </div>
    </body>
</html>