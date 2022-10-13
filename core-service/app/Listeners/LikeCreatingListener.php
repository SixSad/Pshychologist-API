<?php

namespace App\Listeners;

use App\Exceptions\AlreadyExistsException;
use App\Helpers\SessionHelper;
use App\Models\Like;
use Egal\Core\Listeners\GlobalEventListener;
use Egal\Core\Listeners\EventListener;
use Egal\Core\Session\Session;
use Sixsad\Helpers\AbstractEvent;
use Sixsad\Helpers\AbstractListener;

class LikeCreatingListener extends AbstractListener
{

    public function handle(AbstractEvent $event): void
    {
        $model = $event->getModel();

        if (Like::query()->where([
            'post_id' => $model->getAttribute('post_id'),
            'user_id' => SessionHelper::getUUID()
        ])->exists()) {
            throw new AlreadyExistsException();
        }

    }

}
