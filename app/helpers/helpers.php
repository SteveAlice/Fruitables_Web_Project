<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// SEND MAIL FUNCTION USING PHPMAILER LIBRARY.

if ( !function_exists('sendEmail') ){
    function sendEmail($mailConfig)
    {
        require 'PHPMailer/src/Exception.php';
        require 'PHPMailer/src/PHPMailer.php';
        require 'PHPMailer/src/SMTP.php';

        $mail = new PHPMailer(true);
        $mail ->SMTPDebug = 0;
        $mail->isSMTP();                                            //
        $mail->Host       = env('EMAIL_HOST');                      //
        $mail->SMTPAuth   = true;                                   //
        $mail->Username   = env('EMAIL_USERNAME');                   //
        $mail->Password   = env('EMAIL_PASSWORD');                   //
        $mail->SMTPSecure = env('EMAIL_ENCRYPTION');                 //
        $mail->Port       = env('EMAIL_PORT');                       //
           //Recipients
        $mail->setFrom(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
        $mail->addAddress($mailConfig['mail_recipient_email'],$mailConfig['mail_recipient_name']);
        $mail->isHTML(true);
        $mail->Subject = $mailConfig['mail_subject'];
        $mail->Body = $mailConfig['mail_body'];
        if($mail->send()){
            return true;
        }else{
            return false;
        }
    }
}