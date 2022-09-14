<?php
include 'D:\XAMPP\htdocs\AdminLTE-3.2.0\config.php';

session_start();

if(isset($_POST['submit']))
{
    $email = strtolower ($_POST['email']);
    $firstname = strtolower ($_POST['firstname']);
    $password = md5 ($_POST['password']);

    $sql = "SELECT * FROM user where email=:email AND password =:password";
    $query = $dbh->prepare($sql);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':password', $password, PDO::PARAM_STR);
    $query->execute();
    $results=$query->fetch(PDO::FETCH_ASSOC);
    if($query->rowCount() > 0){
        session_regenerate_id();
        $_SESSION['userid'] = $results['userid'];
        header("Location: index.php");
    }
    else{
        echo '<script>alert("Wrong Email or Password")</script>';
    }
    
    
}


?>

<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale-1.0">

        <link rel="stylesheet" type="text/css" href="style.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

        <title>Login Form</title>

    </head>
    <body>
        <div class="container">
            
            <form action="" method="POST" class="login-email">
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
            </form>
        </div>
    </body>
</html>