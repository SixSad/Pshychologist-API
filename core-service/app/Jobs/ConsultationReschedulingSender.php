<?php

namespace App\Jobs;

use App\Helpers\Consts;
use App\Helpers\CreateMail;
use App\Helpers\DateHelper;
use Carbon\Carbon;
use Egal\Model\Model;

class ConsultationReschedulingSender extends Job
{

    private string $oldDate;

    public function __construct(Model $consultation, $oldDate)
    {
        parent::__construct($consultation);
        $this->oldDate = $oldDate;
    }

    public function handle()
    {
        $model = $this->getJobModel();
        $newDate = DateHelper::convertTimezone($model->getAttribute('date'), 3, flag: true, format: 'LLL');
        $client = $model->client;
        $psychologist = $model->psychologist;
        $fio = $client->getAttribute('last_name') . ' ' . $client->getAttribute('first_name') . ' ' . $client->getAttribute('patronymic');

        $body = sprintf("<p>Клиент <b>%s</b> перенёс запись c <b>%s(по Мск.)</b>, на <b>%s(по Мск.)</b></p>",
            $fio,
            Carbon::parse($this->oldDate)->locale('ru')->isoFormat('LLL'),
            $newDate
        );

        $altBody = sprintf("Здравствуйте! Клиент %s перенёс запись с %s(по Мск.), на %s(по Мск.)",
            $fio,
            $this->oldDate,
            $newDate
        );

        $mail = CreateMail::generate($psychologist->getAttribute('email'), $body, $altBody, Consts::EMAIL_SUBJECT_RESCHEDULE);
        $mail->send();

    }
}
