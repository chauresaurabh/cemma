<?php
require 'PHPMailerAutoload.php';

$mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output
 ;                                    // TCP port to connect to

$mail->From = 'cemma@usc.edu';
$mail->FromName = 'Mailer';
$mail->addAddress('chaure@usc.edu', 'Joe User');     // Add a recipient
 
$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
$mail->addAttachment('composer.json');         // Add attachments
 $mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Here is the subject';
$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}