<?php

namespace App\Listeners;

use App\Models\SupportChat;
use Sixsad\Helpers\AbstractEvent;
use Sixsad\Helpers\AbstractListener;

class CreatedSupportMessageUpdateSupportChatStatusListener extends AbstractListener
{

    public function handle(AbstractEvent $event): void
    {
        parent::handle($event);
        $sc = $event->getModel()->supportChat;

        if ($sc->status === true) {
            SupportChat::where("id", $sc->id)->update(["status" => false]);
        }
    }
}
