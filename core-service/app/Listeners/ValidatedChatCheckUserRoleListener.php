<?php

namespace App\Listeners;

use App\Helpers\Consts;
use App\Models\Consultation;
use Carbon\Carbon;
use Egal\Core\Session\Session;
use Error;
use Sixsad\Helpers\AbstractEvent;
use Sixsad\Helpers\AbstractListener;

class ValidatedChatCheckUserRoleListener extends AbstractListener
{

    public function handle(AbstractEvent $event): void
    {
        parent::handle($event);

        $userRoles = Session::getUserServiceToken()->getRoles();

        if (in_array('psychologist', $userRoles)) {

            $userId = Session::getUserServiceToken()->getUid();

            $recipientId = $event->getAttribute("recipient_id");

            $consultation = Consultation::where([
                "client_id" => $recipientId,
                "psychologist_id" => $userId,
            ])->latest()->first();

            if (!$consultation) {
                throw new Error("You do not have access to the client without consultation", 405);
            }

            $now = Carbon::now();
            if ($consultation->getAttribute("status") === Consts::STATUS_CANCELED && $now->subDays(2) > $consultation->updated_at) {
                throw new Error("Consultation expired", 405);
            }
        }
    }
}
