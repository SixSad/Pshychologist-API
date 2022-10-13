<?php

namespace App\Listeners;

use App\Models\ConsultationRoom;
use Egal\Model\Exceptions\ObjectNotFoundException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Sixsad\Helpers\AbstractEvent;
use Sixsad\Helpers\AbstractListener;

class RescheduledUpdateConsultationRoomListener extends AbstractListener
{

    public function handle(AbstractEvent $event): void
    {
        $model = $event->getAttributes();
        $date = Carbon::parse($model['date']);
        $pastDate = $date->addHour();

        $consultationRoom = ConsultationRoom::query()->where('consultation_id', $model['id'])->first();

        if (!$consultationRoom) {
            throw new ObjectNotFoundException();
        }

        ConsultationRoom::actionUpdate($consultationRoom->getAttribute('id'), [
            'room_name' => Hash::make($date->isoFormat('YYYY-MM-DD') . $model['id']),
            'start_time' => $model['date'],
            'end_time' => $pastDate
        ]);
    }

}
