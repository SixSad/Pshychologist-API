<?php

namespace App\Listeners;

use App\Events\DeletedEmailCodeEvent;
use App\Helpers\Consts;
use App\Models\User;

class DeletedEmailCodeUpdateUserListener
{

    public function handle(DeletedEmailCodeEvent $event): void
    {
        User::where("id", $event->getAttribute("user_id"))->update([
            "status" => Consts::STATUS_CONFIRM
        ]);
    }
}
