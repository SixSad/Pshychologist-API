<?php

namespace App\Jobs;

use App\Helpers\Consts;
use App\Helpers\CreateMail;
use App\Helpers\DateHelper;
use Exception;

class ApprovePsychologistSender extends Job
{

    public function handle()
    {
        $model = $this->getJobModel();
        $email = $model->getAttribute('email');

        $body = "<p>Ваша заявка одобрена! Пройдите тестирование на сайте чтобы ваш профиль отображался в подборе</p>";

        $altBody = "Ваша заявка одобрена! Пройдите тестирование на сайте чтобы ваш профиль отображался в подборе";

        try {
            $mail = CreateMail::generate($email, $body, $altBody, Consts::EMAIL_SUBJECT_ACCEPTED);
            $mail->send();
        } catch (Exception $e) {
            echo $e->getMessage();
        }

    }
}
