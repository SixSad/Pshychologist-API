<?php

namespace App\Listeners;

use App\Models\Time;
use Exception;
use Sixsad\Helpers\AbstractEvent;
use Sixsad\Helpers\AbstractListener;

class CreatingTimeValidateListener extends AbstractListener
{

    public function handle(AbstractEvent $event): void
    {
        parent::handle($event);
        $model = $event->getModel();

        if (Time::where(["schedule_id" => $model->getAttribute('schedule_id'), "time" => $model->getAttribute('time')])->exists()) {
            throw new Exception("Time $model->time already exists on schedule_id = $model->schedule_id", 400);
        }
    }

}
