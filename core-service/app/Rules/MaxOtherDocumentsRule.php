<?php

namespace App\Rules;

use Egal\Validation\Rules\Rule as EgalRule;

class MaxOtherDocumentsRule extends EgalRule
{
    public function validate($attribute, $value, $parameters = null): bool
    {
        $other = 0;
        foreach ($value as $item) {
            if ($item['type'] === 'other') {
                $other += 1;
            }
        }
        return $other <= 10;
    }

    public function message(): string
    {
        return 'You cannot attach more than ten other documents.';
    }

}
