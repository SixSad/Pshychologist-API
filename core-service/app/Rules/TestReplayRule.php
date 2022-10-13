<?php

namespace App\Rules;

use App\Models\UserResult;
use Egal\Core\Session\Session;
use Egal\Validation\Rules\Rule as EgalRule;
use Illuminate\Support\Carbon;

class TestReplayRule extends EgalRule
{

    public function validate($attribute, $value, $parameters = null): bool
    {
        $userRole = Session::getUserServiceToken()->getRoles();
        $userId = Session::getUserServiceToken()->getUid();
        $userAnswer = UserResult::query()->where('user_id', $userId)->latest()->first();

        if (in_array('psychologist', $userRole)) {
            return $userAnswer?->getAttribute('created_at') < Carbon::now()->subDays(180);
        }

        return true;
    }

    public function message(): string
    {
        return 'You cannot retake the test';
    }

}
