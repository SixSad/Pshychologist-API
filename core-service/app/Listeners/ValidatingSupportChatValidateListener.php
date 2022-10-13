<?php

namespace App\Listeners;

use App\Helpers\SessionHelper;
use Sixsad\Helpers\AbstractEvent;
use Sixsad\Helpers\AbstractListener;
use Sixsad\Helpers\MicroserviceValidator;

class ValidatingSupportChatValidateListener extends AbstractListener
{

    public function handle(AbstractEvent $event): void
    {
        MicroserviceValidator::validate(['user_id' => SessionHelper::getUUID()], [
            "user_id" => "unique:support_chats,user_id",
        ]);
    }
}
