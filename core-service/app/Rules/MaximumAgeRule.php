<?php

namespace App\Rules;

use Carbon\Carbon;
use Egal\Validation\Rules\Rule as EgalRule;

class MaximumAgeRule extends EgalRule
{
    public function validate($attribute, $value, $parameters = null): bool
    {
        return Carbon::now()->subYears(200) <= Carbon::parse($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'User cannot be older than 200 years.';
    }
}
