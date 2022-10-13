<?php

namespace App\Rules;

use Carbon\Carbon;
use Egal\Validation\Rules\Rule as EgalRule;

class DateEighteenRule extends EgalRule
{
    public function validate($attribute, $value, $parameters = null): bool
    {
        return Carbon::now()->subYears(18)->subDay() >= Carbon::parse($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'User cannot be under 18 years of age.';
    }
}
