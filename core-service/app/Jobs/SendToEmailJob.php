<?php

namespace App\Jobs;

use App\Helpers\Consts;
use App\Helpers\CreateMail;
use App\Models\User;
use Egal\Model\Exceptions\ObjectNotFoundException;
use Exception;

class SendToEmailJob extends Job
{
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $emails = User::all()->pluck('email');

        if (!$emails) {
            throw new ObjectNotFoundException();
        }

        $body = "<p>GJITK YF {EQЗдравствуйте уважаемый пользователь. В тестирование на нашем сайте произошли изменения, пожалуйста, пройдите новое тестирование “ссылка на тестирование”</p>";

        $altBody = "Здравствуйте уважаемый пользователь. В тестирование на нашем сайте произошли изменения, пожалуйста, пройдите новое тестирование “ссылка на тестирование”";

        foreach ($emails as $email) {
            try{
                $mail = CreateMail::generate($email, $body, $altBody, Consts::EMAIL_SUBJECT_TEST_CHANGES);
                $mail->send();
            }catch(Exception $e){
                echo $e->getMessage();
            }

        }
    }
}
