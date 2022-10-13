<?php

namespace App\Models;

use App\Events\CreatedSupportMessageCentrifugoEvent;
use App\Events\CreatedSupportMessageEvent;
use App\Helpers\SessionHelper;
use Egal\Core\Session\Session;
use Egal\Model\Model as EgalModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Query\Builder;

/**
 * @property int $id {@property-type field} {@prymary-key}
 * @property integer $support_chat_id           {@property-type field} {@validation-rules bail|required|int|exists:support_chats,id|check_support_chat}
 * @property string $message            {@property-type field} {@validation-rules required|max:2000}
 * @property string $user_id            {@property-type field} {@validation-rules bail|required|uuid|exists:users,id|check_user_author}
 * @property $created_at {@property-type field}
 * @property $updated_at {@property-type field}
 *
 * @property $user          {@property-type relation}
 *
 * @action create   {@statuses-access logged} {@roles-access user|psychologist|admin|shadow_psychologist}
 * @action getItems {@statuses-access logged} {@roles-access user|psychologist|admin|shadow_psychologist}
 */
class SupportMessage extends EgalModel
{
    protected $fillable = [
        "support_chat_id",
        "message",
        "user_id"
    ];

    protected $dispatchesEvents = [
        'created' => CreatedSupportMessageEvent::class,
        "creating" => CreatedSupportMessageCentrifugoEvent::class,

    ];

    public function newQuery(): \Illuminate\Database\Eloquent\Builder|\Egal\Model\Builder
    {
        if (Session::getActionMessage()->getActionName() === 'getItems' && SessionHelper::getRole() !== 'admin') {
            return parent::newQuery()
                ->whereHas("supportChat", function ($query){
                    $query->where('user_id', SessionHelper::getUUID());
                });
        }

        return parent::newQuery();
    }

    public function supportChat(): BelongsTo
    {
        return $this->belongsTo(SupportChat::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
