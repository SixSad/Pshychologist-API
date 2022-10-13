<?php

namespace App\Listeners;

use App\Helpers\Consts;
use App\Helpers\SessionHelper;
use Sixsad\Helpers\AbstractEvent;
use Sixsad\Helpers\AbstractListener;

class CreatingChatUpdateModelListener extends AbstractListener
{

    public function handle(AbstractEvent $event): void
    {
        parent::handle($event);

        $recipientId = $event->getAttribute("recipient_id");

        $userId = SessionHelper::getUUID();

        if (Consts::ROLE_PSYCHOLOGIST === SessionHelper::getRole()) {
            $event->setModelAttribute("client_id", $recipientId);
            $event->setModelAttribute("psychologist_id", $userId);
        } else {
            $event->setModelAttribute("client_id", $userId);
            $event->setModelAttribute("psychologist_id", $recipientId);
        }
    }
}
