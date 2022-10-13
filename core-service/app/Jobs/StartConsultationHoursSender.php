<?php

namespace App\Jobs;

use App\Helpers\Consts;
use App\Helpers\CreateMail;
use App\Models\Consultation;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class StartConsultationHoursSender extends Job
{

    public function handle()
    {
        $job = DB::table('jobs')->select('available_at')->where('id', '=', $this->job->getJobId())->get();

        if (
            !Consultation::query()
                ->where('date', Carbon::createFromTimestamp($job)->addMinutes(10)->isoFormat('YYYY-MM-DD HH:mm:ss'))
                ->orWhere('date', Carbon::createFromTimestamp($job)->addHours(12)->isoFormat('YYYY-MM-DD HH:mm:ss'))
                ->exists()
        ) {
            $this->fail('Wrong consultation time');
        }

        $model = $this->getJobModel();
        $client = $model->client;
        $psychologist = $model->psychologist;

        $body = "<p>Через <b>12 часов</b>, у вас начнется конференция.<p>";
        $altBody = 'Здравствуйте! Через 12 часов, у вас начнется конференция.';

        $mails[] = CreateMail::generate($psychologist->getAttribute('email'), $body, $altBody, Consts::EMAIL_SUBJECT_REMINDER);
        $mails[] = CreateMail::generate($client->getAttribute('email'), $body, $altBody, Consts::EMAIL_SUBJECT_REMINDER);

        foreach ($mails as $mail) {
            $mail->send();
        }

    }
}
