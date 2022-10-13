<?php

namespace App\Listeners;

use App\Events\RetrievedScheduleEvent;
use App\Helpers\DateHelper;
use App\Helpers\SessionHelper;
use App\Models\Schedule;
use App\Models\Time;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Sixsad\Helpers\AbstractEvent;
use Sixsad\Helpers\AbstractListener;

class RetrievedScheduleAdminListener extends AbstractListener
{

    public function handle(AbstractEvent $event): void
    {

        $schedule = $event->getModel();
        $tz = SessionHelper::getTimezone();
        $schedule->setAttribute('date', DateHelper::getDate($schedule->getAttribute('week_day'), $tz)->isoFormat('YYYY-MM-DD'));
        $psychologistId = $schedule->getAttribute('psychologist_id');

        $times = DB::select("SELECT * FROM get_timetable('$psychologistId')");

        $times = array_filter($times, (function ($time) use ($schedule, $tz) {

            if ($time->schedule_time === null) {
                return false;
            }
            $date = DateHelper::getDate($time->week_day, $tz, true);
            $checkTime = DateHelper::convertTimezone(DateHelper::dateTimeConcat($date, $time->schedule_time), $tz);
            $time->time = $checkTime->isoFormat('HH:00:00');
            $time->id = $time->time_id;
            unset($time->psychologist_id, $time->week_day, $time->time_id, $time->schedule_time);

            return $checkTime > Carbon::now($tz)->addHours(12)
                && $checkTime >= Carbon::createFromDate($schedule['date'], $tz)
                && $checkTime < Carbon::createFromDate($schedule['date'], $tz)->addDay();
        }));

        usort($times, function ($a, $b) {
            return (strtotime($a->time) - strtotime($b->time));
        });

        $event->setModelAttribute('times', $times);
        $event->clearModelAttribute('expiration_date');

    }

}
