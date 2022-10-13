<?php

namespace App\Helpers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class CreateMail
{
    public function __construct(
        private readonly string $email,
        private readonly string $code,
        private readonly string $status = "email"
    ) {
    }

    public function generate(): PHPMailer
    {
        $text = Consts::MAIL_TEXT[$this->status];

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
        $mail->addAddress($this->email);

        $mail->isHTML(true);

        $mail->Subject = Consts::MAIL_SUBJECT[$this->status];

        $mail->Body = "<h1>Здравствуйте!</h1>
        <p>Вы получили это письмо, потому что на нашем сервисе для $text был указан адрес вашей электронной почты.</p>
        <p>Для подтверждения вашего аккаунта введите код:<p>
        <div style='background:#faf9fa;border:1px solid #dad8de;text-align:center;padding:5px;margin:0 0 5px 0;font-size:24px;line-height:1.5;width:80%'> $this->code </div>
        С уважением, команда сервиса M.Connection.";

        $mail->AltBody = "Здравствуйте!
        Вы получили это письмо, потому что на нашем сервисе для $text был указан адрес вашей электронной почты.
        Для подтверждения вашего аккаунта введите код:
        $this->code
        С уважением, команда сервиса M.Connection.";


        $mail->CharSet = "UTF-8";

        return $mail;
    }
}
