<?php

namespace App\Rules;

use Egal\Validation\Rules\Rule as EgalRule;

class AnswersWrongFieldsRule extends EgalRule
{

    public function validate($attribute, $value, $parameters = null): bool
    {
        foreach ($value as $item) {
            $wrongAttributes = array_diff_key($item, [
                'question_id' => '',
                'answer_option' => '',
            ]);

            if (!empty($wrongAttributes)) {
                return false;
            }
        }
        return true;
    }

    public function message(): string
    {
        return 'Only question answer fields can be filled.';
    }

}
