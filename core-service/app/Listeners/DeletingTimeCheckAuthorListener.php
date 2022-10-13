<?php

namespace App\Listeners;

use App\Helpers\SessionHelper;
use App\Models\Time;
use Exception;
use Sixsad\Helpers\AbstractEvent;
use Sixsad\Helpers\AbstractListener;

class DeletingTimeCheckAuthorListener extends AbstractListener
{
    /**
     * @property Time $consultation
     */
    public function handle(AbstractEvent $event): void
    {
        $id = $event->getAttribute("id");
        $time = $event->getModel();
        $psyId = $time->schedule->getAttribute("psychologist_id");

        $user = SessionHelper::getUUID();

        if ($user !== $psyId) {
            throw new Exception("The $id must have your id", 400);
        }
    }
}
