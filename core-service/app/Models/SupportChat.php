<?php

namespace App\Models;

use App\Events\CreatingSupportChatEvent;
use App\Events\ValidatingSupportChatEvent;
use App\Helpers\SessionHelper;
use Egal\Core\Session\Session;
use Egal\Model\Model as EgalModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;

/**
 * @property $id {@property-type field} {@prymary-key}
 * @property $status {@property-type field} {@validation-rules boolean}
 * @property $user_id {@property-type field}
 * @property $created_at {@property-type field}
 * @property $updated_at {@property-type field}
 *
 * @property Collection $user          {@property-type relation}
 * @property Collection $latest_support_message          {@property-type relation}
 *
 * @action create {@statuses-access logged} {@roles-access user|psychologist|shadow_psychologist}
 * @action update {@statuses-access logged} {@roles-access admin}
 * @action getItems {@statuses-access logged} {@roles-access admin|user|psychologist|shadow_psychologist}
 */
class SupportChat extends EgalModel
{
    protected $dispatchesEvents = [
        "validating" => ValidatingSupportChatEvent::class,
        "creating" => CreatingSupportChatEvent::class,
    ];

    protected $fillable = [
        "status",
    ];

    public function newQuery()
    {
        if (Session::getActionMessage()->getActionName() === 'getItems' && SessionHelper::getRole() !== 'admin') {
            return parent::newQuery()->where("user_id", SessionHelper::getUUID());
        }

        return parent::newQuery()->with("latestSupportMessage");
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function latestMessage(): HasMany
    {
        return $this->messages()->latestOfMany();
    }

    public function messages(): HasMany
    {
        return $this->hasMany(SupportMessage::class);
    }

    public function latestSupportMessage(): HasOne
    {
        return $this->hasOne(SupportMessage::class)->latestOfMany();
    }
}
