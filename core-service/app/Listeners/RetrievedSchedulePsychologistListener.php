<?php

namespace App\Listeners;

use App\Helpers\DateHelper;
use App\Helpers\SessionHelper;
use App\Models\Consultation;
use App\Models\Schedule;
use App\Models\Time;
use Carbon\Carbon;
use Sixsad\Helpers\AbstractEvent;
use Sixsad\Helpers\AbstractListener;

class RetrievedSchedulePsychologistListener extends AbstractListener
{

    public function handle(AbstractEvent $event): void
    {
        $schedule = $event->getModel();
        $tz = SessionHelper::getTimezone();
        $schedule->setAttribute('date', DateHelper::getDate($schedule->getAttribute('week_day'), $tz)->isoFormat('YYYY-MM-DD'));
        $schedules = Schedule::query()->where('psychologist_id', $schedule->getAttribute('psychologist_id'))->get();

        $times = Time::query()->whereIn('schedule_id', $schedules->pluck('id'))->get()->filter(function ($time) use ($tz, $schedule) {
            $scheduleDate = DateHelper::getDate($time->schedule->week_day, flag: true);
            $dateTime = DateHelper::dateTimeConcat($scheduleDate, $time['time']);

            $consultation = Consultation::query()
                ->where([
                    'psychologist_id' => $schedule->getAttribute('psychologist_id'),
                    'date' => $dateTime,
                    'status' => 'booked'
                ])->first();

            if ($consultation) {
                $time['status'] = $consultation->getAttribute('status');
                $time['consultation_id'] = $consultation->getAttribute('id');
            } else {
                $time['status'] = "free";
            }

            $time['time'] = DateHelper::convertTimezone($time['time'], $tz, flag: true, format: 'HH:00:00');
            $dateTimeWithTimezone = DateHelper::convertTimezone($dateTime, $tz, flag: true);
            unset($time['schedule']);

            return $dateTimeWithTimezone >= $schedule->getAttribute('date') && $dateTimeWithTimezone < Carbon::parse($schedule->getAttribute('date'))->addDay();
        });

        $schedule->setAttribute('times', $times->sortBy('time')->values());
    }

}
