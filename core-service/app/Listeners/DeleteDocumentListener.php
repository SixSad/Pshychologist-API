<?php

namespace App\Listeners;

use App\Exceptions\EmptyPasswordException;
use App\Exceptions\ForbiddenDeleteDocumentException;
use App\Exceptions\NoAccessException;
use App\Helpers\SessionHelper;
use App\Models\User;
use Egal\Model\Exceptions\ValidateException;
use Sixsad\Helpers\AbstractEvent;
use Sixsad\Helpers\AbstractListener;

class DeleteDocumentListener extends AbstractListener
{
    /**
     * @param AbstractEvent $event
     * @throws EmptyPasswordException
     * @throws ValidateException
     * @property User $user
     */
    public function handle(AbstractEvent $event): void
    {
        $attributes = $event->getModel()->getAttributes();

        if ($attributes['psychologist_data_id'] !== SessionHelper::getUUID()) {
            throw new NoAccessException();
        }

        if ($attributes["type"] !== "other") {
            throw new ForbiddenDeleteDocumentException;
        }

    }
}
