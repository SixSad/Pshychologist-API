<?php

namespace App\Listeners;

use App\Exceptions\UnableToCreateException;
use App\Helpers\Consts;
use App\Models\Consultation;
use App\Models\ConsultationRoom;
use Carbon\Carbon;
use Egal\Model\Exceptions\ObjectNotFoundException;
use Illuminate\Support\Facades\Hash;
use Sixsad\Helpers\AbstractEvent;
use Sixsad\Helpers\AbstractListener;

class CreatingConsultationRoomAttachAttributeListener extends AbstractListener
{

    public function handle(AbstractEvent $event): void
    {
        parent::handle($event);
        /**
         * @param ConsultationRoom $model
         */
        $model = $event->getModel();
        $consultation = Consultation::query()->find($event->getAttribute('consultation_id'));

        if (!Consultation::query()->find($model->getAttribute('consultation_id'))) {
            throw new ObjectNotFoundException();
        }

        $consultationDate = $consultation->getAttribute('date');

        if ($consultation->getAttribute('status') !== Consts::STATUS_BOOKED || $consultationDate < Carbon::now()) {
            throw new UnableToCreateException;
        }

        $consultationEndDate = Carbon::parse($consultationDate)->addHour();
        $roomName = Carbon::parse($consultationDate)->isoFormat('YYYY-MM-DD') . $consultation->getAttribute('id');

        $model->setAttribute('room_name', Hash::make($roomName));
        $model->setAttribute('start_time', $consultationDate);
        $model->setAttribute('end_time', $consultationEndDate);

    }
}
