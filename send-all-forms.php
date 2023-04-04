<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/PHPMailer.php';
require 'phpmailer/Exception.php';
require 'phpmailer/SMTP.php';

//Config
$host_smtp  = "";   // Specify main and backup SMTP servers
$user       = "";   // SMTP username
$pass       = "";   // SMTP password
$from_email = "";
$from_name  = "";
$to         = "";
$port       = "";   // TCP port to connect to
$sec        = "";   // tls or ssl

$text_copy  = "Este e-mail foi enviado através do website. Não responda este e-mail.";
$positive_return = "Sucess";
$negative_return = "Error";

//Insert the allowed forms ID into the Array
$allowed = false;
$allowed_forms = array(
    'contact-form',
    'contact-form-2',
);

//Checks if the received form can be registered in the array
if(isset($_POST['form'])) {
    foreach($allowed_forms as $form_name){
        if($form_name == $_POST['form']){
            $allowed = true;
            break;
        }
    } 
}

if($allowed){
    $fields_body = '';
    $subject = isset($_POST['ignore-subject']) ? $_POST['ignore-subject'] : "Contact Form";

    foreach($_POST as $key => $value){
        if($key != "form"){
            $key_exploded = explode("-",$key);
            if($key_exploded['0'] != 'ignore' && $key_exploded['0'] != 'hidden'){
                $fields_body.= "<strong>".$key."</strong>: ".$value." <br/>";
            }
        }
    }

    $body = "
        <html>
            <body>
                <h1>".$subject."</h1>
                ".$fields_body." <br/>
                ".$text_copy."
            </body>
        </html>";

    $mail = new PHPMailer(true);    // Passing `true` enables exceptions
    try {
        //Server settings
        $mail->CharSet = 'UTF-8';
        $mail->SMTPDebug = false;   // Enable verbose debug output
        $mail->isSMTP();            // Set mailer to use SMTP
        $mail->Host = $host_smtp;
        $mail->SMTPAuth = true;     // Enable SMTP authentication
        $mail->Username = $user;
        $mail->Password = $pass;
        $mail->SMTPSecure = $sec;
        $mail->Port = $port;

        //Recipients
        $mail->setFrom($from_email, $from_name);
        $mail->addAddress($to);

        //Content
        $mail->isHTML(true);        // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $body;
        $mail->send();

        if(isset($_POST['ignore-page-redrect'])){
            header ("Location: ".$_POST['ignore-page-redrect']);
        }else{
            echo $positive_return;
        }
    } catch (Exception $e) {
        echo $negative_return;
    }
}