<?php
include 'D:\PROGRAMMING SOFTWARES\XAMPP\htdocs\Capstone\config.php';
session_start();

if (isset($_SESSION['userid'])) {
    header("Location: index.php");
}

if (isset($_POST['submit'])) {
    $firstname = strtoupper($_POST['firstname']);
    $lastname = strtoupper($_POST['lastname']);
    $email = strtolower($_POST['email']);
    $password = ($_POST['password']);
    $vkey = md5(time() . $firstname);

    $sql = "SELECT * FROM user WHERE email =:email";
    $query = $dbh->prepare($sql);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetch(PDO::FETCH_ASSOC);
    if ($query->rowCount() > 0) {
        echo '<script>alert("Email is already taken!")</script>';
    } else {
        $sql = "INSERT INTO user(firstname, lastname, email, password, vkey, usertype)VALUES(:firstname, :lastname, :email, :password, '$vkey', 'user')";
        $query = $dbh->prepare($sql);
        $query->bindParam(':firstname', $firstname, PDO::PARAM_STR);
        $query->bindParam(':lastname', $lastname, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->execute();
        echo '<script>alert("Registered Successfully! Verification link is send to your email")</script>';

        try {
            include('phpmailer.php');

            $mail->setFrom('420overflow@zohomail.com', 'Overflow Admin');
            $mail->addAddress($email);     //Add a recipient
            $message = " <!DOCTYPE html>
                    <html lang='en' >
                    <head>
                    <meta charset='UTF-8'>
                    <title>Verify Email</title>
                    </head>
                    <body>
                    <div>
                    <p>
                    Hello there,
                    </p>
                    <p>
                    </p>
                    <p>
                    Please click on the link below to verify your email.
                    </p>
                    <p>
                    </p>
                    <a href='http://localhost/capstone/pages/verify.php?vkey=$vkey'>
                    Verify your email
                    </a>
                    </div>
                    </body>
                    </html>";
            //Content
            $mail->isHTML(true);
            $mail->Subject = 'Email Verification';
            $mail->Body    = $message;

            $mail->send();
        } catch (Exception $e) {
            echo '<script>alert("Invalid Email address!")</script>';
        }

        echo "<script type ='text/javascript'> document.location.href='login.php' </script>";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale-1.0">

    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <title>Register Form</title>

</head>

<body>
    <div class="container">

        <form action="" method="POST" class="login-email">
            <a href="../index.php"><img src="../dist/img/overflowlgoo.jpg" alt="Logo" style="height:100px;margin-top:-40px;margin-left:120px;"></a>
            <p class="login-text" style="font-size: 2rem; font-weight:800;">Register</p>
            <div class="input-group">
                <input type="text" placeholder="Firstname" name="firstname" required>
            </div>
            <div class="input-group">
                <input type="text" placeholder="Lastname" name="lastname" required>
            </div>
            <div class="input-group">
                <input type="email" placeholder="Email" name="email" required>
            </div>
            <div class="input-group">
                <input type="password" placeholder="Password" name="password" required>
            </div>
            <div class="input-group">
                <button name="submit" class="btn">Register</button>
            </div>
            <p class="login-register-text">Have an account yet? <a href="login.php">Login Here!</a></p>
        </form>
    </div>
</body>

</html>