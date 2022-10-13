<?php

namespace App\Listeners;

use App\Helpers\SessionHelper;
use App\Models\Consultation;
use App\Models\Time;
use Carbon\Carbon;
use Exception;
use Sixsad\Helpers\AbstractEvent;
use Sixsad\Helpers\AbstractListener;

class DeletingTimeValidateListener extends AbstractListener
{
    /**
     * @property Time $consultation
     */
    public function handle(AbstractEvent $event): void
    {
        $today = Carbon::today();
        $tomorrow = Carbon::tomorrow();
        $time = $event->getModel();
        $id = $time->getAttribute("id");

        $weekDay = $time->schedule->getAttribute('week_day');
        if ($weekDay === $today->format("d") || $weekDay === $tomorrow->format("d")) {
            if (Consultation::where([
                "psychologist_id" => SessionHelper::getUUID(),
                "status" => "booked"
            ])
                ->whereDate("date", $today->format("Y-m-d"))
                ->orWhereDate("date", $tomorrow->format("Y-m-d"))
                ->get()
            ) {
                throw new Exception("$id not avaible", 405);
            };
        }
    }
}
