<?php

namespace App\Rules;

use App\Helpers\SessionHelper;
use Egal\Validation\Rules\Rule as EgalRule;
use Illuminate\Support\Facades\DB;

class UniversalCheckAuthorRule extends EgalRule
{

    public function validate($attribute, $value, $parameters = null): bool
    {
        $table = DB::table($parameters[0]);

        if (count($parameters) > 2) {
            $collection = $table->where($parameters[2], $value)->get();
        } else {
            $collection = $table->where("id", $value)->get();
        }

        $userId = $collection->pluck($parameters[1])->first();

        return SessionHelper::getUUID() === $userId;
    }

    public function message(): string
    {
        return "The :attribute must have your id";
    }
}
