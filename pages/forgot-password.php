<?php
include 'C:\xampp\htdocs\AdminLTE-3.2.0\config.php';

session_start();
if (isset($_SESSION['userid'])) {
    if ($_GET['usertype'] = "admin") {
        header("Location: admin.php");
    } else {
        header("Location: index.php");
    }
}

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $sql = "SELECT * FROM user WHERE email=:email";
    $query = $dbh->prepare($sql);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetch(PDO::FETCH_ASSOC);

    $vkey = $results['vkey'];

    if ($query->rowCount() > 0) {
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
                    Please click on the link below to reset your password.
                    </p>
                    <p>
                    </p>
                    <a href='http://localhost/adminLTE-3.2.0/pages/new-password.php?vkey=$vkey'>
                    Reset your password
                    </a>
                    </div>
                    </body>
                    </html>";
            //Content
            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Link';
            $mail->Body    = $message;

            $mail->send();
        } catch (Exception $e) {
            echo '<script>alert("Invalid Email address!")</script>';
        }

        echo '<script>alert("We have sent a password reset link to your email - ' . $email . '")</script>';
        echo "<script type ='text/javascript'> document.location.href='login.php' </script>";
    } else {
        echo '<script>alert("Email Address does not exist!")</script>';
    }
}



?>

<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale-1.0">

    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <title>Forgot Password</title>

</head>

<body>
    <div class="container">

        <form action="" method="POST" class="login-email">
            <a href="../index.php"><img src="../dist/img/overflowlgoo.jpg" alt="Logo" style="height:100px;margin-top:-40px;margin-left:120px;"></a>
            <p class="login-text" style="font-size: 2rem; font-weight:800;">Forgot Password</p>
            <div class="input-group">
                <input type="email" placeholder="Email" name="email" required>
            </div>
            <div class="input-group">
                <button name="submit" class="btn">Submit</button>
            </div>
            <p class="login-register-text" style="padding-left: 150px;"><a href="login.php">Back!</a></p>
        </form>
    </div>
</body>

</html>