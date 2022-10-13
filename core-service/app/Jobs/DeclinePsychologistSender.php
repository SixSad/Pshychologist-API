<?php

namespace App\Jobs;

use App\Helpers\Consts;
use App\Helpers\CreateMail;
use App\Helpers\DateHelper;
use Illuminate\Database\Eloquent\Collection;

class DeclinePsychologistSender extends Job
{

    private array $messages;

    public function __construct($messages, $model = null)
    {
        parent::__construct($model);
        $this->messages = $messages;
    }

    public function handle()
    {
        $model = $this->getJobModel();
        $fio = $model->getAttribute('first_name') . ' ' . $model->getAttribute('last_name') . ' ' . $model->getAttribute('patronymic');


        if ($model->getAttribute('role') === "shadow_psychologist") {
            $body = sprintf(
                "<p>Здравствуйте уважаемый $fio ваша заявка была рассмотрена и предварительно отклонена.
                    Для того чтобы ваша заявка была успешно одобрена, исправьте ошибки которые описаны ниже :</p>%s",
                implode("<br>", $this->messages)
            );

            $altBody = sprintf(
                "Здравствуйте уважаемый $fio, ваша заявка была рассмотрена и предварительно отклонена.
                    Для того чтобы ваша заявка была успешно одобрена, исправьте ошибки которые описаны ниже : %s",
                implode(' ', $this->messages)
            );

            $mail = CreateMail::generate($model->getAttribute('email'), $body, $altBody, Consts::EMAIL_SUBJECT_REFUSED);
            $mail->send();
        }

        if ($model->getAttribute('role') === "psychologist") {
            $body = sprintf(
                "<p>Здравствуйте уважаемый $fio, загруженные вами документы были отклонены.
                    Для того чтобы документы были успешно одобрены, исправьте ошибки которые описаны ниже :</p>%s",
                implode("<br>", $this->messages)
            );

            $altBody = sprintf(
                "Здравствуйте уважаемый $fio, загруженные вами документы были отклонены.
                    Для того чтобы документы были успешно одобрены, исправьте ошибки которые описаны ниже : %s",
                implode(' ', $this->messages)
            );

            $mail = CreateMail::generate($model->getAttribute('email'), $body, $altBody, Consts::EMAIL_SUBJECT_REFUSED);
            $mail->send();
        }
    }
}
