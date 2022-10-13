<?php

namespace App\Listeners;

use App\Jobs\ConsultationNewSender;
use App\Jobs\StartConsultationHoursSender;
use App\Jobs\StartConsultationMinutesSender;
use App\Models\ConsultationRoom;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Queue;
use Sixsad\Helpers\AbstractEvent;
use Sixsad\Helpers\AbstractListener;

class CreatedConsultationAttachRoomListener extends AbstractListener
{
    public function handle(AbstractEvent $event): void
    {
        parent::handle($event);
        $id = $event->getAttribute('id');
        $attribute['consultation_id'] = $id;

        $firstNotifications = Carbon::parse($event->getAttribute('date'))->subHours(12);
        $secondNotifications = Carbon::parse($event->getAttribute('date'))->subMinutes(10);

        ConsultationRoom::actionCreate($attribute);

        dispatch(new ConsultationNewSender($event->getModel()));
        Queue::later($firstNotifications, new StartConsultationHoursSender($event->getModel()));
        Queue::later($secondNotifications, new StartConsultationMinutesSender($event->getModel()));

    }

}
