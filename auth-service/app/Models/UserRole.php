<?php

namespace App\Models;

use Egal\Model\Model;

/**
 * @property integer $id {@primary-key} {@property-type field}
 * @property string $user_id {@property-type field} {@validation-rules required|uuid|exists:users}
 * @property integer $role_id {@property-type field} {@validation-rules required|string|exists:roles,id}
 * @property $created_at {@property-type field}
 * @property $updated_at {@property-type field}
 *
 * @action changeStatus {@services-access core}
 * @action getItem {@roles-access admin,developer}
 * @action getItems {@roles-access admin,developer} {@services-access core}
 * @action create {@roles-access admin,developer}
 * @action update {@roles-access admin,developer} {@services-access core}
 * @action delete {@roles-access admin,developer}
 * @action updateManyRaw {@services-access core}
 */
class UserRole extends Model
{
    protected $fillable = [
        'user_id',
        'role_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
