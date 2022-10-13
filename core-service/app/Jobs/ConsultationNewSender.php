<?php

namespace App\Jobs;

use App\Helpers\Consts;
use App\Helpers\CreateMail;
use App\Helpers\DateHelper;

class ConsultationNewSender extends Job
{

    public function handle()
    {
        $model = $this->getJobModel();

        $client = $model->client;
        $psychologist = $model->psychologist;
        $fio = $client->getAttribute('first_name') . ' ' . $client->getAttribute('last_name') . ' ' . $client->getAttribute('patronymic');
        $date = DateHelper::convertTimezone($model->getAttribute('date'), 3, flag: true, format: 'LLL');

        $body = sprintf("<p>К вам записался клиент - <b>%s</b></p><p>На: <b>%s(по Мск.)</b><p>",
            $fio,
            $date
        );

        $altBody = sprintf("Здравствуйте! К вам записался клиент %s. На %s(по Мск.)",
            $fio,
            $date,
        );

        $mail = CreateMail::generate($psychologist->getAttribute('email'), $body, $altBody, Consts::EMAIL_SUBJECT_NEW);
        $mail->send();
    }
}
