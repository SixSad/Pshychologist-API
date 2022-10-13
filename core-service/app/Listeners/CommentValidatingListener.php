<?php

namespace App\Listeners;

use App\Helpers\SessionHelper;
use Egal\Core\Session\Session;
use Sixsad\Helpers\AbstractEvent;
use Sixsad\Helpers\AbstractListener;

class CommentValidatingListener extends AbstractListener
{

    public function handle(AbstractEvent $event): void
    {
        $model = $event->getModel();

        if (Session::getActionMessage()->getActionName() === 'create') {
            $model->setAttribute('user_id', SessionHelper::getUUID());
        }
    }

}
