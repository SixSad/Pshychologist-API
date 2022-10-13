<?php

namespace App\Listeners;

use App\Helpers\SessionHelper;
use Egal\Core\Session\Session;
use Sixsad\Helpers\AbstractEvent;
use Sixsad\Helpers\AbstractListener;

class RetrievedScheduleDispatchListener extends AbstractListener
{

    public function handle(AbstractEvent $event): void
    {
        if (Session::getActionMessage()->getActionName() !== 'getItems') {
            return;
        }

        if (SessionHelper::getRole() === 'admin') {
            (new RetrievedScheduleAdminListener())->handle($event);
        }

        if (SessionHelper::getRole() === 'user') {
            (new RetrievedScheduleUserListener())->handle($event);
        }

        if (SessionHelper::getRole() === 'psychologist') {
            (new RetrievedSchedulePsychologistListener())->handle($event);
        }

    }

}
