<?php

namespace App\Listeners;

use App\Models\Schedule;
use Egal\Core\Session\Session;
use Sixsad\Helpers\AbstractEvent;
use Sixsad\Helpers\AbstractListener;
use Sixsad\Helpers\SessionAttributes;

class CreatingTimeValidateUniqueListener extends AbstractListener
{
    public function handle(AbstractEvent $event): void
    {
        $psychologist = Session::getUserServiceToken()->getUid();
        $schedules = Schedule::query()->where('psychologist_id', $psychologist)->get();

        $schedules->each(function ($item) {
            $item->setAttribute('expiration_date', SessionAttributes::getAttributes()['expiration_date']);
            return $item->save();
        });

    }
}
