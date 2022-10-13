<?php

namespace App\Jobs;

use App\Helpers\Consts;
use App\Helpers\CreateMail;
use App\Helpers\DateHelper;

class PsychologistBanSender extends Job
{
    public string $message;

    public function __construct($message, $model = null)
    {
        parent::__construct($model);
        $this->message = $message;
    }

    public function handle()
    {
        $model = $this->getJobModel();
        $email = $model->getAttribute('email');
        $fio = $model->getAttribute('last_name') . ' ' . $model->getAttribute('first_name') . ' ' . $model->getAttribute('patronymic');

        $body = "<p>Здравствуйте уважаемый(ая) $fio.
                    Ваш аккаунт на сервисе mind connection был заблокирован. Причина: <b>$this->message</b>.
                    Вы можете оспорить решение по блокировке, связавшись с нами по почте <b>(karnauhova.dariya@yandex.ru, zamasha37@gmail.com)</b> или по номеру телефона <b>+7(923)722-20-50</b>.</p>";

        $altBody = "Здравствуйте уважаемый(ая) $fio.
                    Ваш аккаунт на сервисе mind connection был заблокирован. Причина: $this->message.
                    Вы можете оспорить решение по блокировке, связавшись с нами по почте (karnauhova.dariya@yandex.ru, zamasha37@gmail.com) или по номеру телефона +7(923)722-20-50.";

        $mail = CreateMail::generate($email, $body, $altBody, Consts::EMAIL_SUBJECT_BAN);
        $mail->send();
    }
}
