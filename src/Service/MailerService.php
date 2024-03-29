<?php

namespace App\Service;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use Twig\Environment;

class MailerService
{
    private PHPMailer $mail;
//private = seule la classe peut voir/utiliser l'attibut
//protected = la classe et ses héritières peuvent voir/utiliser l'attribut
//public = tout le monde peut voir/utiliser l'attribut
    private Environment $twig;

    public function __construct(Environment $twig)
    {

        $this->twig = $twig;

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

    public function sendRegisterSuccess(string $email, string $firstname, string $lastname)
    {
        $this->mail->addAddress($email, $firstname . '' . $lastname);
        $this->mail->isHTML(true);
        $this->mail->Subject = 'Inscription à Shop';
        $this->mail->Body = $this->twig->render("/mail/register.html.twig", [
            'email' => $email
        ]);

        $this->mail->Send();
    }

    public function sendPasswordChange(string $email, string $firstname, string $lastname)
    {
        $this->mail->addAddress($email, $firstname . '' . $lastname);
        $this->mail->isHTML(true);
        $this->mail->Subject = 'Inscription à Shop';
        $this->mail->Body = $this->twig->render("/mail/password.html.twig", [
            'email' => $email
        ]);

        $this->mail->Send();
    }

    public function Commandegood(string $email, string $firstname, string $lastname)
    {
        $this->mail->addAddress($email, $firstname . '' . $lastname);
        $this->mail->isHTML(true);
        $this->mail->Subject = 'Commande passer ';
        $this->mail->Body = $this->twig->render("/mail/commande.html.twig", [
            'email' => $email
        ]);

        $this->mail->Send();
    }
}