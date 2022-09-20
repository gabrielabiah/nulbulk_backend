<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
  
require_once "vendor/autoload.php";

$postdata = file_get_contents("php://input");
$getdata = json_decode($postdata);
if($postdata){

$full_name = trim($getdata->full_name);
$phone_number = trim($getdata->phone_number);
$email = trim($getdata->email);
$subject = trim($getdata->subject);
$message = trim($getdata->message);
$admin_email = trim($getdata->admin_email);
$site_name = trim($getdata->site_name);
$receiver_email = trim($getdata->receiver_email);
$receiver_name = trim($getdata->receiver_name);
}


$mail = new PHPMailer(true);
  
try {
    $mail->isSMTP();
    $mail->Host = 'in-v3.mailjet.com'; // host
    $mail->SMTPAuth = true;
    $mail->Username = '1edd6b66ad78e66b7b9dbe9cf828cbf8'; //username
    $mail->Password = '57c5a905e538d4eb5444261d30c13564'; //password
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587; //smtp port
    
    $mail->setFrom($admin_email, $site_name);
    $mail->addAddress($receiver_email, $receiver_name);
  
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body    = "<h3> $subject </h3><p>$message</p><br>From:<h4>$full_name<br>$phone_number<br>$email</h4>";
  
    $mail->send();
    print_r('Email has been sent.');
} catch (Exception $e) {
    echo 'Email could not be sent. Mailer Error: '. $mail->ErrorInfo;
}

