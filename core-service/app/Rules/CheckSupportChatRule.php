<?php

namespace App\Rules;

use App\Helpers\SessionHelper;
use App\Models\SupportChat;
use Egal\Validation\Rules\Rule as EgalRule;

class CheckSupportChatRule extends EgalRule
{

    public function validate($attribute, $value, $parameters = null): bool
    {
        return SessionHelper::getRole() === "admin"
            ? true
            : SupportChat::where([
                "user_id" => SessionHelper::getUUID(),
                "id" => $value
            ])->exists();
    }

    public function message(): string
    {
        return "Not your chat";
    }
}
