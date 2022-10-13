<?php

namespace App\Helpers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class CreateMail
{

    public static function generate(
        string $email,
        string $body,
        string $altBody,
        string $subject,
        string $header = "<h1>Здравствуйте!</h1>",
        string $footer = "<p style='text-align: end'><br>С уважением, команда сервиса M.Connection.</p>"): PHPMailer

    {
        $config = config("email");

        $mail = new PHPMailer(true);

        $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->isSMTP();
        $mail->Host = 'smtp.mail.ru';
        $mail->SMTPAuth = true;
        $mail->Username = $config['email'];
        $mail->Password = $config['password'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        $mail->setFrom($config['email'], $config['name']);
        $mail->addAddress($email);

        $mail->isHTML(true);

        $mail->Subject = $subject;

        $mail->Body = $header . $body . $footer;

        $mail->AltBody = $altBody;

        $mail->CharSet = "UTF-8";

        return $mail;
    }

}
