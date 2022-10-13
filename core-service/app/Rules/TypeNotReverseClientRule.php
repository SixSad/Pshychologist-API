<?php

namespace App\Rules;

use App\Models\Question;
use Egal\Core\Session\Session;
use Egal\Validation\Rules\Rule as EgalRule;
use Sixsad\Helpers\SessionAttributes;

class TypeNotReverseClientRule extends EgalRule
{
    public function validate($attribute, $value, $parameters = null): bool
    {
        $attributes = SessionAttributes::getAttributes();
        $params = Session::getActionMessage()->getParameters();

        if (array_key_exists("id", $params)) {
            $model = Question::find($params['id']);
        }

        if ((isset($attributes['type']) && $attributes['type'] !== 'one') || (isset($model) && $model->type !== "one")) {
            return true;
        }

        if (array_key_exists('client_reverse', $attributes)) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return "If the question type is one, the client reverse field should be omitted.";
    }
}
