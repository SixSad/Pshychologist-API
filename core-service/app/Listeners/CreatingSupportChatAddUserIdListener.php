<?php

namespace App\Listeners;

use App\Helpers\SessionHelper;
use Sixsad\Helpers\AbstractEvent;
use Sixsad\Helpers\AbstractListener;
use Sixsad\Helpers\MicroserviceValidator;

class CreatingSupportChatAddUserIdListener extends AbstractListener
{

    public function handle(AbstractEvent $event): void
    {
        parent::handle($event);
        MicroserviceValidator::validate(["user_id" => SessionHelper::getUUID()], [
            "user_id" => 'uuid|exists:users,id'
        ]);

        $event->setModelAttribute("user_id", SessionHelper::getUUID());
    }
}
