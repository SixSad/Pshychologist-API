<?php

namespace App\Events;

use Egal\Centrifugo\CentrifugoEvent;

class CreatedMessageCentrifugoEvent extends CentrifugoEvent
{
    public function broadcastOn(): array
    {
        $parentEntity = $this->entity->chat()->first();
        $service = config('app.service_name');

        $parentEntityChannel = $service . '@' . get_class_short_name($parentEntity) . '.' . $parentEntity->id;
        $channels[] = $parentEntityChannel;

        return $channels;
    }
}
