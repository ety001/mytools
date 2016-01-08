#!/usr/bin/php
<?php
date_default_timezone_set('Asia/Shanghai');
include './vendor/autoload.php';
$mail = new PHPMailer;

echo 1;
//$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.163.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                            // Enable SMTP authentication
$mail->Username = 'ety001@163.com';                 // SMTP username
$mail->Password = '3vh6s47p@163.com';                           // SMTP password
//$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 25;                                    // TCP port to connect to

$mail->setFrom('ety001@163.com', 'Mailer');
$mail->addAddress($argv[2], 'Joe User');     // Add a recipient

//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Here is the subject '.date('Y-m-d H:i:s', time());
$h = file_get_contents($argv[1]. '.html');
$mail->Body    = $h;

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}
