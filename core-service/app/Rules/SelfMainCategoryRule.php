<?php

namespace App\Rules;

use Egal\Core\Session\Session;
use Egal\Validation\Rules\Rule as EgalRule;
use Sixsad\Helpers\SessionAttributes;

class SelfMainCategoryRule extends EgalRule
{
    public function validate($attribute, $value, $parameters = null): bool
    {
        $attributes = SessionAttributes::getAttributes();
        if (!array_key_exists('category_id', $attributes) or !array_key_exists('id', Session::getActionMessage()->getParameters())) {
            return true;
        }

        $id = Session::getActionMessage()->getParameters()['id'];
        return $id !== $attributes['category_id'];
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return "A category cannot be nested within itself.";
    }
}
