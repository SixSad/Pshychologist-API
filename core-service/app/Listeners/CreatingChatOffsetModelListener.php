<?php

namespace App\Listeners;

use Sixsad\Helpers\AbstractEvent;
use Sixsad\Helpers\AbstractListener;

class CreatingChatOffsetModelListener extends AbstractListener
{

    public function handle(AbstractEvent $event): void
    {
        parent::handle($event);

        $event->clearModelAttribute("recipient_id");
    }
}
