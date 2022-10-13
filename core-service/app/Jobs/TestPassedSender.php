<?php

namespace App\Jobs;

use App\Helpers\Consts;
use App\Helpers\CreateMail;

class TestPassedSender extends Job
{

    public function handle()
    {
        $model = $this->getJobModel();

        $body = "<p>Благодарим Вас за участие в первом этапе тестирования в рамках научного исследования от экспертов Томского Государственного Университета.
                 <br><br>Второй этап - обратная связь о Вашем сеансе с психологом. Это наиболее важный аспект исследования, и мы просим Вас заполнить форму обратной связи о работе с психологом, которая доступна по данной ссылке - <a href='http://sputnik.tomtit-tomsk.ru/landing/feedBack.html'>Форма</a>.
                 <br><br>Напоминаем, что все данные используются лишь в рамках исследования и не передаются третьим лицам, даже Вашему психологу.
                 Спасибо, что развиваете науку вместе с нами!</p>";

        $altBody = 'Благодарим Вас за участие в первом этапе тестирования в рамках научного исследования от экспертов Томского Государственного Университета
                    Второй этап - обратная связь о Вашем сеансе с психологом. Это наиболее важный аспект исследования, и мы просим Вас заполнить форму обратной связи о работе с психологом, которая доступна по данной ссылке
                    Напоминаем, что все данные используются лишь в рамках исследования и не передаются третьим лицам, даже Вашему психологу
                    Спасибо, что развиваете науку вместе с нами!';

        $mail = CreateMail::generate($model->getAttribute('email'), $body, $altBody, Consts::EMAIL_SUBJECT_TEST_PASSED);
        $mail->send();
    }
}
