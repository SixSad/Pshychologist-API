<?php

namespace App\Models;

use App\Events\CreatingChatEvent;
use App\Events\ValidatedChatEvent;
use App\Helpers\Consts;
use App\Helpers\SessionHelper;
use Carbon\Carbon;
use Egal\Core\Session\Session;
use Egal\Model\Model as EgalModel;
use Exception;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;
use Sixsad\Helpers\MicroserviceValidator;

/**
 * @property integer $id             {@property-type field} {@primary-key}
 * @property string $client_id       {@property-type field} {@validation-rules uuid|exists:users,id}
 * @property string $psychologist_id {@property-type field} {@validation-rules uuid|exists:users,id}
 * @property string $recipient_id    {@property-type fake-field} {@validation-rules bail|required|uuid|exists:users,id|check_user_role:user,psychologist|check_opposite_role|check_chat_unique}
 * @property Carbon $created_at      {@property-type field}
 * @property Carbon $updated_at      {@property-type field}
 *
 * @property Collection $client          {@property-type relation}
 * @property Collection $psychologist    {@property-type relation}
 * @property Collection $messages        {@property-type relation}
 * @property Collection $latest_message  {@property-type relation}
 *
 * @action create {@statuses-access logged} {@roles-access user|psychologist}
 * @action checkChat {@statuses-access logged} {@roles-access user|psychologist}
 * @action getItems {@statuses-access logged} {@roles-access user|psychologist}
 */
class Chat extends EgalModel
{
    protected $dispatchesEvents = [
        "validated" => ValidatedChatEvent::class,
        "creating" => CreatingChatEvent::class,
    ];

    protected $fillable = [
        "recipient_id"
    ];

    public function newQuery()
    {

        if (Session::getActionMessage()->getActionName() === 'getItems' && SessionHelper::getRole() === 'user') {
            return parent::newQuery()->where("client_id", SessionHelper::getUUID())->with(
                [
                    "psychologist:id,first_name,last_name",
                    "psychologist.psychologistData:id,avatar",
                    "latestMessage"
                ]
            );
        }

        if (Session::getActionMessage()->getActionName() === 'getItems' && SessionHelper::getRole() === 'psychologist') {
            return parent::newQuery()->where("psychologist_id", SessionHelper::getUUID())->with(
                [
                    "client:id,first_name,last_name",
                    "latestMessage"
                ]
            );
        }

        return parent::newQuery();
    }

    public static function actionCheckChat(array $attributes): string
    {
        MicroserviceValidator::validate($attributes, [
            "recipient_id" => "bail|required|uuid|exists:users,id|check_user_role:user,psychologist|check_opposite_role|check_chat_unique",
        ]);

        $userRoles = Session::getUserServiceToken()->getRoles();

        if (in_array('psychologist', $userRoles)) {

            $userId = Session::getUserServiceToken()->getUid();

            $recipientId = $attributes["recipient_id"];

            $consultation = Consultation::where([
                "client_id" => $recipientId,
                "psychologist_id" => $userId,
            ])->latest()->first();

            if (!$consultation) {
                throw new Exception("You do not have access to the client without consultation", 405);
            }

            $now = Carbon::now();
            if ($consultation->getAttribute("status") === Consts::STATUS_CANCELED && $now->subDays(2) > $consultation->updated_at) {
                throw new Exception("Consultation expired", 405);
            }
        }

        return "Ok";
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function psychologist(): BelongsTo
    {
        return $this->belongsTo(User::class, 'psychologist_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function latestMessage(): HasOne
    {
        return $this->hasOne(Message::class)->latestOfMany();
    }
}
