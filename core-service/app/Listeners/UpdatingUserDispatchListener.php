<?php

namespace App\Listeners;

use App\Helpers\SessionHelper;
use Sixsad\Helpers\AbstractEvent;
use Sixsad\Helpers\AbstractListener;

class UpdatingUserDispatchListener extends AbstractListener
{

    public function handle(AbstractEvent $event): void
    {
        if (SessionHelper::getRole() === 'admin') {

            (new UpdatingUserChangeRoleListener())->handle($event);
        }

        if (SessionHelper::getRole() === 'user' || SessionHelper::getRole() === 'psychologist' || SessionHelper::getRole() === 'shadow_psychologist') {

            (new UserChangeDataListener())->handle($event);
        }
    }

}
