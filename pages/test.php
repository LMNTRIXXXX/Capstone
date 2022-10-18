<?php

include('phpmailer.php');

$mail->setFrom('420overflow@zohomail.com', 'Overflow Admin');
$mail->addAddress('manigoscarljohn@gmail.com');     //Add a recipient

//Content
$mail->isHTML(true);                                  //Set email format to HTML
$mail->Subject = 'Email Verification';
$mail->Body    = 'This is the HTML message body <b>in bold!</b>';

$mail->send();
