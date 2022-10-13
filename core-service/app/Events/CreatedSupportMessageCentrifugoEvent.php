<?php

namespace App\Events;

use Egal\Centrifugo\CentrifugoEvent;

class CreatedSupportMessageCentrifugoEvent extends CentrifugoEvent
{
    public function broadcastOn(): array
    {
        $parentEntity = $this->entity->supportChat()->first();
        $service = config('app.service_name');
        $parentEntityChannel = $service . '@' . get_class_short_name($parentEntity) . '.' . $parentEntity->id;
        $channels[] = $parentEntityChannel;

        return $channels;
    }
}
