<?php

namespace App\Jobs;

use App\Helpers\Consts;
use App\Helpers\CreateMail;
use App\Helpers\DateHelper;

class ConsultationPsychologistCanceledSender extends Job
{

    public function handle()
    {
        $model = $this->getJobModel();
        $client = $model->client;
        $psychologist = $model->psychologist;
        $date = DateHelper::convertTimezone($model->getAttribute('date'), 3,  flag: true, format: 'LLL');
        $fio = $psychologist->getAttribute('first_name') . ' ' . $psychologist->getAttribute('last_name') . ' ' . $psychologist->getAttribute('patronymic');

        $body = sprintf("<p>Психолог- <b>%s</b> отменил запись на <b>%s(по Мск.)</b></p>
                                <p>Вы можете отменить запись и вернуть деньги, либо выбрать другую дату приема на сайте</p>",
            $fio,
            $date
        );

        $altBody = sprintf("Здравствуйте! Психолог %s отменил запись на %s(по Мск.).
                                   Вы можете вернуть деньги или выбрать другую дату приема на сайте",
            $fio,
            $date,
        );

        $mail = CreateMail::generate($client->getAttribute('email'), $body, $altBody, Consts::EMAIL_SUBJECT_CANCELED);
        $mail->send();
    }
}
