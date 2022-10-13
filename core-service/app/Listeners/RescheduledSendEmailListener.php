<?php

namespace App\Listeners;

use App\Helpers\DateHelper;
use App\Jobs\ConsultationReschedulingSender;
use App\Jobs\StartConsultationMinutesSender;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Queue;
use Sixsad\Helpers\AbstractEvent;
use Sixsad\Helpers\AbstractListener;

class RescheduledSendEmailListener extends AbstractListener
{

    public function handle(AbstractEvent $event): void
    {
        $firstNotifications = Carbon::parse($event->getAttribute('date'))->subHours(12);
        $secondNotifications = Carbon::parse($event->getAttribute('date'))->subMinutes(10);

        dispatch(new ConsultationReschedulingSender($event->getModel(), DateHelper::convertTimezone($event->getModel()->getOriginal()['date'], 3, 0, 'LLL')));
        Queue::later($firstNotifications, new StartConsultationMinutesSender($event->getModel()));
        Queue::later($secondNotifications, new StartConsultationMinutesSender($event->getModel()));
    }

}
