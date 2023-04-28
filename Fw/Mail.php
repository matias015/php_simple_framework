<?php

include_once('PHPMailer/PHPMailer.php');
include_once('PHPMailer/Exception.php');
include_once('PHPMailer/SMTP.php');
include_once('App/config/config.php');


//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mail{

    private static $instance = null;

    static function init(){
        Mail::$instance = new PHPMailer(true);
        
        //Mail::$instance->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        Mail::$instance->isSMTP();                                            //Send using SMTP
        Mail::$instance->Host       = MAIL_HOST;                     //Set the SMTP server to send through
        Mail::$instance->SMTPAuth   = MAIL_SMTP_AUTH;                                   //Enable SMTP authentication
        Mail::$instance->Username   = MAIL_USERNAME;                     //SMTP username
        Mail::$instance->Password   = MAIL_PASSWORD;                               //SMTP password
        Mail::$instance->SMTPSecure = 'tls';            //Enable implicit TLS encryption
        Mail::$instance->Port       = MAIL_PORT;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    }

    static function to($to,$subject,$body,$altBody){

        try {
            
            //Recipients
            Mail::$instance->setFrom('a@example.com', 'Mailer');
            Mail::$instance->addAddress($to);               //Name is optional
            Mail::$instance->addReplyTo('c@example.com', 'Information');
            Mail::$instance->addCC('d@example.com');
            Mail::$instance->addBCC('e@example.com');

            //Attachments
            //Mail::$instance->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            //Mail::$instance->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            //Content
            Mail::$instance->isHTML(true);                                  //Set email format to HTML
            Mail::$instance->Subject = $subject;
            Mail::$instance->Body    = $body;
            Mail::$instance->AltBody = $altBody;

            Mail::$instance->send();
            return true;
        } catch (Exception $e) {
            //echo "Message could not be sent. Mailer Error: {Mail::$instance->ErrorInfo}";
            return false;
        }    


    }
}

Mail::init();