<?php

namespace App\Helpers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class CreateMailRejected
{
    public static function generate(string $email, string $code, string $status): PHPMailer
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

        $mail->Subject = $status == "Qualification"
            ? "Заявка отклонена"
            : "Заявка принята";

        $mail->Body = "<h1>Здравствуйте!</h1>
        <p>Вы получили это письмо, потому что на нашем сервисе для регистрации был указан адрес вашей электронной почты.</p>
        <p>При просмотре вашей заявки, админимтратор выявил некоторы проблемы:<p>
        <p>$code</p>
        <p>С уважением, команда сервиса M.Connection.</p>";

        $mail->AltBody = "Здравствуйте!
        Вы получили это письмо, потому что на нашем сервисе для регистрации был указан адрес вашей электронной почты.
        При просмотре вашей заявки, админимтратор выявил некоторы проблемы:
        $code
        С уважением, команда сервиса M.Connection.";

        $mail->CharSet = "UTF-8";

        return $mail;
    }
}
