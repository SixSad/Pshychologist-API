<?php

namespace App\Listeners;

use Sixsad\Helpers\AbstractEvent;
use Sixsad\Helpers\AbstractListener;

class UpdatedConsultationListener extends AbstractListener
{

    public function handle(AbstractEvent $event): void
    {
        $model = $event->getModel();
        $changes = $model->getChanges();

        if (array_key_exists('date', $changes)) {
            (new RescheduledSendEmailListener())->handle($event);
            (new RescheduledUpdateConsultationRoomListener())->handle($event);
        }

        if (array_key_exists('status', $changes)) {
            (new UpdatingConsultationStatusSendEmailListener())->handle($event);
        }
    }

}
