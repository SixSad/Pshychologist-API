<?php

namespace App\Events;

use Egal\Centrifugo\CentrifugoEvent;

class SavedConsultationCentrifugoEvent extends CentrifugoEvent
{
    public function broadcastOn(): array
    {
        $service = config('app.service_name');

        $entity = $this->entity;

        $channelNames[] = $service . '@' . get_class_short_name($entity) . '.' . $entity->getKey();

        return $channelNames;
    }
}
