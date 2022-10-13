<?php

namespace App\Jobs;

use App\Helpers\Consts;
use App\Helpers\CreateMail;
use App\Helpers\DateHelper;

class ConsultationUserCanceledSender extends Job
{

    public function handle()
    {
        $model = $this->getJobModel();
        $client = $model->client;
        $psychologist = $model->psychologist;
        $fio = $client->getAttribute('first_name') . ' ' . $client->getAttribute('last_name') . ' ' . $client->getAttribute('patronymic');
        $date = DateHelper::convertTimezone($model->getAttribute('date'), 3, flag: true, format: 'LLL');

        $body = sprintf("<p>Клиент- <b>%s</b> отменил запись на <b>%s(по Мск.)</b><p>",
            $fio,
            $date
        );

        $altBody = sprintf("Здравствуйте! Клиент %s отменил запись на %s",
            $fio,
            $date,
        );

        $mail = CreateMail::generate($psychologist->getAttribute('email'), $body, $altBody, Consts::EMAIL_SUBJECT_CANCELED);
        $mail->send();
    }
}
