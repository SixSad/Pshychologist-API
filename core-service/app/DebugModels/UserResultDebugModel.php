<?php

namespace App\DebugModels;

use App\Exceptions\NoAccessException;
use App\Helpers\AlgorithmHelper;
use App\Helpers\ArrayHelper;
use App\Models\Question;
use App\Models\User;
use App\Models\UserResult;
use Error;
use App\Helpers\SqlHelper;

/**
 * @property $id {@property-type field} {@prymary-key}
 * @property $name {@property-type field} {@validation-rules required|string}
 * @property $created_at {@property-type field}
 * @property $updated_at {@property-type field}
 *
 * @action getMyPsychologists {@statuses-access guest|logged}
 */
class UserResultDebugModel extends UserResult
{


  protected $table = "user_results";
}
