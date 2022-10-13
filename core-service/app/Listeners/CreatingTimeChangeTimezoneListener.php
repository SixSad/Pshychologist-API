<?php

namespace App\Listeners;

use App\Helpers\DateHelper;
use App\Helpers\SessionHelper;
use App\Models\Schedule;
use Sixsad\Helpers\AbstractEvent;
use Sixsad\Helpers\AbstractListener;

class CreatingTimeChangeTimezoneListener extends AbstractListener
{

    public function handle(AbstractEvent $event): void
    {
        parent::handle($event);
        $time = $event->getModel();
        $oldTime = $event->getAttribute('time');
        $scheduleWeekday = Schedule::query()->find($time->getAttribute('schedule_id'))->getAttribute('week_day');
        $date = DateHelper::getDate($scheduleWeekday, SessionHelper::getTimezone(), 'YYYY-MM-DD');
        $weekdayWithTimezone = DateHelper::convertTimezone(DateHelper::dateTimeConcat($date, $oldTime), 0, SessionHelper::getTimezone());

        $schedule = Schedule::query()->where([
            'week_day' => $weekdayWithTimezone->isoFormat('d'),
            'psychologist_id' => SessionHelper::getUUID()
        ])->first();

        $time->setAttribute('schedule_id', $schedule->getAttribute('id'));
        $time->setAttribute('time', $weekdayWithTimezone->isoFormat('HH:mm:ss'));
    }

}
