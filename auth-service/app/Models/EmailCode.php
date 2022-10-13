<?php

namespace App\Models;

use App\Events\DeletedEmailCodeEvent;
use App\Events\DeletingEmailCodeEvent;
use App\Helpers\Consts;
use Egal\Model\Model as EgalModel;
use Sixsad\Helpers\MicroserviceValidator;

/**
 * @property $id {@property-type field} {@prymary-key}
 * @property $code {@property-type field} {@validation-rules required|string|min:6|max:6}
 * @property $user_id {@property-type field} {@validation-rules required|exists:users,id}
 * @property $type {@property-type field} {@validation-rules required|enum:email,password}
 * @property $created_at {@property-type field}
 * @property $updated_at {@property-type field}
 *
 * @property Collection $user {@property-type relation}
 *
 * @action confirmMail {@statuses-access guest}
 */
class EmailCode extends EgalModel
{
    protected $fillable = [
        'code',
        'user_id',
        'type'
    ];

    protected $guarder = [
        'name',
        'user_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $dispatchesEvents = [
        'deleting' => DeletingEmailCodeEvent::class,
        "deleted" => DeletedEmailCodeEvent::class
    ];

    public static function actionConfirmMail(array $attributes): string
    {
        $type = Consts::TYPE_EMAIL;

        MicroserviceValidator::validate($attributes, [
            "code" => "required|check_code:$type"
        ]);

        $emailCode = self::query()
            ->where([
                "code" => $attributes['code'],
                "type" => $type
            ])
            ->first();

        $emailCode->delete();

        return "Email confirmed";
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
