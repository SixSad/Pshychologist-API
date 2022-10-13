<?php

namespace App\Jobs;

use App\Helpers\Consts;
use App\Helpers\CreateMail;
use App\Helpers\DateHelper;

class PsychologistUnbanSender extends Job
{

    public function handle()
    {
        $model = $this->getJobModel();
        $email = $model->getAttribute('email');
        $fio = $model->getAttribute('last_name') . ' ' . $model->getAttribute('first_name') . ' ' . $model->getAttribute('patronymic');

        $body = "<p>Здравствуйте уважаемый(ая) $fio.
        Ваш аккаунт на сервисе mind connection был разблокирован.
        Теперь вы можете пользоваться функционалом всего сервиса!</p>";

        $altBody = "Здравствуйте уважаемый(ая) $fio.
        Ваш аккаунт на сервисе mind connection был разблокирован.
        Теперь вы можете пользоваться функционалом всего сервиса!";

        $mail = CreateMail::generate($email, $body, $altBody, Consts::EMAIL_SUBJECT_UNBAN);
        $mail->send();
    }
}
