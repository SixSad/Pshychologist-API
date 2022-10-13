<?php

namespace App\Listeners;

use App\Helpers\DateHelper;
use App\Helpers\SessionHelper;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Sixsad\Helpers\AbstractEvent;
use Sixsad\Helpers\AbstractListener;

class RetrievedScheduleUserListener extends AbstractListener
{

    public function handle(AbstractEvent $event): void
    {
        $schedule = $event->getModel();
        $tz = SessionHelper::getTimezone();
        $id = $schedule->getAttribute('psychologist_id');
        $now = Carbon::now();
        $next = Carbon::now()->addDays(7);
        $event->setModelAttribute('date', DateHelper::getDate($schedule->getAttribute('week_day'), $tz)->isoFormat('YYYY-MM-DD'));

        $times = collect(DB::select("SELECT * FROM get_schedule('$now','$next','$id')"))
            ->map(
                function ($time) use ($schedule, $tz) {
                    $date = DateHelper::getDate($time->week_day, $tz, true);
                    if ($time->consultation_time === null) {
                        return false;
                    }
                    return DateHelper::convertTimezone(DateHelper::dateTimeConcat($date, $time->consultation_time), $tz, flag: true);
                })
            ->filter(function ($time) use ($schedule, $tz) {
                $scheduleDate = Carbon::parse($schedule['date'], $tz);
                return $time > Carbon::now($tz)->addHours(12)
                    && $time >= $scheduleDate
                    && $time < $scheduleDate->addDay();
            })
            ->sort()
            ->values();

        $event->setModelAttribute('times', $times);
        $event->clearModelAttribute('expiration_date');
    }

}
