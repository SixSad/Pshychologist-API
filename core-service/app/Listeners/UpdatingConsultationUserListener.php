<?php

namespace App\Listeners;

use App\Exceptions\NoAccessException;
use App\Exceptions\UpdateException;
use App\Helpers\ArrayHelper;
use App\Helpers\DateHelper;
use App\Helpers\SessionHelper;
use Carbon\Carbon;
use Exception;
use Sixsad\Helpers\AbstractEvent;
use Sixsad\Helpers\AbstractListener;
use Sixsad\Helpers\MicroserviceValidator;
use Sixsad\Helpers\SessionAttributes;

class UpdatingConsultationUserListener extends AbstractListener
{

    public function handle(AbstractEvent $event): void
    {
        $model = $event->getModel();
        $id = SessionHelper::getUUID();
        $status = $model->getOriginal('status');
        $updated = $model->getDirty();

        if ($id !== $model->getAttribute('client_id')) {
            throw new NoAccessException();
        }

        if (count($updated) > 1) {
            throw new UpdateException();
        }

        if ($status !== 'booked') {
            throw new Exception("Consultation already $status", 400);
        }

        if (in_array('date', $updated) && Carbon::parse($model->getAttribute('date'))->subHours(8) < Carbon::now()) {
            throw new Exception("You cannot reschedule before 8 hours", 400);
        }

        MicroserviceValidator::validate(SessionAttributes::getAttributes(), [
            'status' => 'bail|filled|string|in:canceled',
            'date' => "bail|date_format:Y-m-d H:00:00|check_time_before:8|check_schedule:$model->id|same_date_to_reschedule:$model->id|unique_consultation:$model->id",
        ]);

        ArrayHelper::arrayFilter($model->getDirty(), ['status', 'date']);

        $model->setAttribute('date', DateHelper::convertTimezone($model->getAttribute('date'), 0, SessionHelper::getTimezone(), true));

    }

}
