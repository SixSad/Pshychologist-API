<?php

namespace App\DebugModels;

use App\Helpers\SendRequest;
use App\Helpers\UserSeederRequest;
use App\Models\User;

/**
 * @property $id {@property-type field} {@prymary-key}
 * @property $name {@property-type field} {@validation-rules required|string}
 * @property $created_at {@property-type field}
 * @property $updated_at {@property-type field}
 *
 * @action getUserResult {@statuses-access guest|logged}
 */
class UserDebugModel extends User
{
    public static function actionGetUserResult($id)
    {
        $response = UserSeederRequest::send("core", "UserResultDebugModel", "getMyPsychologists", [
            "id" => $id
        ]);

        return $response->getActionResultMessage() ? $response->getActionResultMessage()->toArray() : $response->getActionErrorMessage()->toArray();
    }

    protected $table = "users";
}
