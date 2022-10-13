<?php

namespace App\Rules;

use App\Models\WorkCategory;
use Egal\Validation\Rules\Rule as EgalRule;

class OneMethodRule extends EgalRule
{
    public function validate($attribute, $value, $parameters = null): bool
    {
        foreach ($value as $item) {
            $workCategory = WorkCategory::query()->findOrFail($item);
            if ($workCategory->type === 'method') {
                return true;
            }
        }
        return false;
    }

    public function message(): string
    {
        return 'You must attach at least one category with type method.';
    }

}
