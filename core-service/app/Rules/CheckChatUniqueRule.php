<?php

namespace App\Rules;

use App\Helpers\SessionHelper;
use App\Models\Chat;
use Egal\Core\Session\Session;
use Egal\Validation\Rules\Rule as EgalRule;

class CheckChatUniqueRule extends EgalRule
{

    public function validate($attribute, $value, $parameters = null): bool
    {
        $userId = Session::getUserServiceToken()->getUid();
        $userRole = SessionHelper::getRole();
        if ($userRole === "psychologist") {
            $chat = Chat::where([
                "client_id" => $value,
                "psychologist_id" => $userId
            ]);
        } else {
            $chat = Chat::where([
                "client_id" => $userId,
                "psychologist_id" => $value
            ]);
        }
        return !$chat->first();
    }

    public function message(): string
    {
        return "Сhat exists";
    }
}
