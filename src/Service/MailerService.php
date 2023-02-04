<?php

namespace App\Service;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class MailerService
{
    public $mail;

    public function __construct() {
        $this->mail = new PHPMailer(true);
        $this->mail->CharSet = "UTF-8";
        $this->mail->IsSMTP(); // active SMTP
        $this->mail->SMTPDebug = SMTP::DEBUG_OFF;

        $this->mail->SMTPAuth = true;  // Authentification SMTP active
        $this->mail->SMTPSecure = 'ssl'; // Gmail REQUIERT Le transfert securise
        $this->mail->Host = 'smtp.mailosaur.net';
        $this->mail->Port = 465;
        $this->mail->Username = 'vjjsxfsc@mailosaur.net';
        $this->mail->Password = 'B4kE8P6JSsaKm4jO';

        $this->mail->setFrom('noreply@shop.fr', 'Shop');
    }

    public function sendRegisterSuccess(string $to)
    {
        $this->mail->addAddress($email, $firstname . '' . $lastname);
        $this->mail->isHTML(true);
        $this->mail->Subject = 'Inscription à Shop';
        $this->mail->Body = $twig->render("/mail/register_message.html.twig", [
            'email' => $email
        ]);

        $this->mail->Send();
    }
}