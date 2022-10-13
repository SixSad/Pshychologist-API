<?php

namespace App\Listeners;

use App\Exceptions\NoAccessException;
use App\Helpers\SessionHelper;
use Sixsad\Helpers\AbstractEvent;
use Sixsad\Helpers\AbstractListener;

class PostUpdatingListener extends AbstractListener
{

    public function handle(AbstractEvent $event): void
    {
        $model = $event->getModel();

        if ($model->getAttribute('user_id') !== SessionHelper::getUUID()) {
            throw new NoAccessException();
        }
    }

}
