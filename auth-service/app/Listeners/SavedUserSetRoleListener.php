<?php

namespace App\Listeners;

use App\Events\SavedUserEvent;
use Sixsad\Helpers\SessionAttributes;

class SavedUserSetRoleListener
{

    public function handle(SavedUserEvent $event): void
    {
        $role = SessionAttributes::getAttributes()['role'];
        /**
         * App\Models\Users
         */
        $user = $event->getModel();
        $user->roles()->attach($role);
    }
}
