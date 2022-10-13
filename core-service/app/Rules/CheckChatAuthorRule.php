<?php

namespace App\Rules;

use App\Models\Chat;
use Egal\Core\Session\Session;
use Egal\Validation\Rules\Rule as EgalRule;

class CheckChatAuthorRule extends EgalRule
{

    public function validate($attribute, $value, $parameters = null): bool
    {
        $chat = Chat::query()->find($value);

        $userId = Session::getUserServiceToken()->getUid();

        return $chat->client_id === $userId || $chat->psychologist_id === $userId;
    }

    public function message(): string
    {
        return 'Not your chat.';
    }
}
