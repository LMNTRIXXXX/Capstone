<?php
date_default_timezone_set('Asia/Singapore');
$currentdate = date('Y-m-d');

$sql = "SELECT * FROM notes WHERE status = 'To Do'";
$query = $dbh->prepare($sql);
$query->execute();
$results = $query->fetchALL(PDO::FETCH_OBJ);
foreach ($results as $result) {
  $reminddate = htmlentities($result->reminddate);
  $notesname = htmlentities($result->notesname);
  $updateid = htmlentities($result->notesid);
  $headerid = htmlentities($result->folderid);
  $userid = htmlentities($result->userid);

  if ($currentdate == $reminddate) {
    $message = "My aybols naa kay reminder sa notes na $notesname";
    $header = "index.php?folderid=$headerid";
    $sql = "INSERT INTO notification(receiverid, message, date, header)VALUES($userid, '$message', NOW(), '$header')";
    $query = $dbh->prepare($sql);
    $query->execute();

    $sql = "UPDATE notes SET status = 'Must Do' WHERE notesid = $updateid";
    $query = $dbh->prepare($sql);
    $query->execute();
  }
}
