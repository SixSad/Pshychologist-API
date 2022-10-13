<?php

namespace App\Listeners;

use App\Helpers\Consts;
use App\Helpers\SessionHelper;
use App\Jobs\ConsultationPsychologistCanceledSender;
use App\Models\Consultation;
use Illuminate\Support\Carbon;
use Sixsad\Helpers\AbstractEvent;
use Sixsad\Helpers\AbstractListener;

class DeletedTimeCancelConsultationListener extends AbstractListener
{

    public function handle(AbstractEvent $event): void
    {
        parent::handle($event);

        $time = $event->getModel();

        $schedule = $time->schedule;

        $date = Carbon::today()->weekday($schedule->week_day) >= Carbon::today()
            ? Carbon::today()->weekday($schedule->week_day)->isoFormat('YYYY-MM-DD')
            : Carbon::today()->addDays(7)->weekday($schedule->week_day)->isoFormat('YYYY-MM-DD');

        $consultation = Consultation::query()->where(['psychologist_id' => SessionHelper::getUUID(), 'date' => "$date $time->time", "status" => Consts::STATUS_BOOKED]);

        if ($consultation) {
            dispatch(new ConsultationPsychologistCanceledSender($consultation->first()));
            $consultation->update([
                "status" => Consts::STATUS_CANCELED
            ]);
        }
    }
}
