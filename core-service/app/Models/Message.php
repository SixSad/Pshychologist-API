<?php

namespace App\Models;

use App\Events\CreatedMessageCentrifugoEvent;
use App\Helpers\SessionHelper;
use Carbon\Carbon;
use Egal\Core\Session\Session;
use Egal\Model\Builder;
use Egal\Model\Model as EgalModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;
use Sixsad\Helpers\MicroserviceValidator;

/**
 * @property integer $id                {@property-type field} {@primary-key}
 * @property integer $chat_id           {@property-type field} {@validation-rules bail|required|int|exists:chats,id|check_chat_author|check_recipient_role:user,psychologist}
 * @property string $message            {@property-type field} {@validation-rules required|max:2000}
 * @property string $user_id            {@property-type field} {@validation-rules required|uuid|exists:users,id|check_user_author}
 * @property Carbon $created_at         {@property-type field}
 * @property Carbon $updated_at         {@property-type field}
 *
 * @property Collection $user           {@property-type relation}
 * @property Collection $chat         {@property-type relation}
 *
 * @action create {@statuses-access logged} {@roles-access user|psychologist}
 * @action checkMessage {@statuses-access logged} {@roles-access user|psychologist}
 * @action getItems {@statuses-access logged} {@roles-access user|psychologist}
 */
class Message extends EgalModel
{
    protected $fillable = [
        "chat_id",
        "message",
        "user_id"
    ];

    protected $dispatchesEvents = [
        'created' => CreatedMessageCentrifugoEvent::class
    ];

    public function newQuery()
    {

        if (Session::getActionMessage()->getActionName() === 'getItems' && SessionHelper::getRole() === 'user') {
            return parent::newQuery()
                ->whereHas("chat", fn (Builder $query) => $query->where("client_id", SessionHelper::getUUID()));

        }

        if (Session::getActionMessage()->getActionName() === 'getItems' && SessionHelper::getRole() === 'psychologist') {
            return parent::newQuery()
                ->whereHas("chat", fn (Builder $query) => $query->where("psychologist_id", SessionHelper::getUUID()));
        }

        return parent::newQuery();
    }

    public static function actionCheckMessage(array $attributes): string
    {
        MicroserviceValidator::validate($attributes, [
            "chat_id" => "bail|required|int|exists:chats,id|check_chat_author|check_recipient_role:user,psychologist",
        ]);

        return "Ok";
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function chat(): BelongsTo
    {
        return $this->BelongsTo(Chat::class);
    }
}
