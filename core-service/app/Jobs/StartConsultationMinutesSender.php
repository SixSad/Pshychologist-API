<?php

namespace App\Jobs;

use App\Helpers\Consts;
use App\Helpers\CreateMail;
use App\Models\Consultation;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class StartConsultationMinutesSender extends Job
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
        $fioPsychologist = $psychologist->getAttribute('first_name') . ' ' . $psychologist->getAttribute('last_name') . ' ' . $psychologist->getAttribute('patronymic');
        $fioClient = $client->getAttribute('first_name') . ' ' . $client->getAttribute('last_name') . ' ' . $client->getAttribute('patronymic');

        $bodyClient = "<p>Через <b>10 минут</b>, у вас начнется конференция c $fioPsychologist<p>";
        $altBodyClient = "Здравствуйте! Через 10 минут, у вас начнется конференция с $fioPsychologist";

        $bodyPsychologist = "<p>Через <b>10 минут</b>, у вас начнется конференция с $fioClient.<p>";
        $altBodyPsychologist = "Здравствуйте! Через 10 минут, у вас начнется конференция с $fioClient.";

        $mails[] = CreateMail::generate($psychologist->getAttribute('email'), $bodyPsychologist, $altBodyPsychologist, Consts::EMAIL_SUBJECT_REMINDER);
        $mails[] = CreateMail::generate($client->getAttribute('email'), $bodyClient, $altBodyClient, Consts::EMAIL_SUBJECT_REMINDER);

        foreach ($mails as $mail) {
            $mail->send();
        }

    }
}
