<?php
include 'D:\PROGRAMMING SOFTWARES\XAMPP\htdocs\Capstone\config.php';
session_start();

$sql1 = "SELECT * FROM user";
$query1 = $dbh->prepare($sql1);
$query1->execute();
$results = $query1->fetchALL(PDO::FETCH_OBJ);
foreach ($results as $result) {

    $userid = htmlentities($result->userid);
    $message = "Please do your journal";
    $header = "journal.php";
    $sql2 = "INSERT INTO notification(receiverid, message, date, header)VALUES($userid, '$message', NOW(), '$header')";
    $query2 = $dbh->prepare($sql2);
    $query2->execute();
    header("Location: " . $_SERVER["HTTP_REFERER"]);
}
