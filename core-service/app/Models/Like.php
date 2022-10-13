<?php

namespace App\Models;

use App\Events\LikeCreatingEvent;
use App\Events\LikeDeletingEvent;
use App\Events\LikeValidatingEvent;
use App\Listeners\LikeCreatingListener;
use Carbon\Carbon;
use Egal\Model\Model as EgalModel;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;

/**
 * @property int $id                {@property-type field} {@prymary-key}
 * @property int $post_id           {@property-type field} {@validation-rules required|int}
 * @property string $user_id        {@property-type field} {@validation-rules required|uuid}
 * @property Carbon $created_at     {@property-type field}
 * @property Carbon $updated_at     {@property-type field}
 *
 * @property Collection $post                   {@property-type relation}
 *
 * @action getItem  {@statuses-access guest|logged}
 * @action getItems {@statuses-access guest|logged}
 * @action create   {@statuses-access logged} {@roles-access user|psychologist|admin}
 * @action deleteManyRaw   {@statuses-access logged} {@roles-access user|psychologist|admin}
 */
class Like extends EgalModel
{

    protected $fillable = [
        'post_id',
        'user_id'
    ];

    protected $dispatchesEvents = [
        'validating' => LikeValidatingEvent::class,
        'creating' => LikeCreatingEvent::class,
        'deleting' => LikeDeletingEvent::class
    ];

    public function post(): HasOne
    {
        return $this->hasOne(Post::class, 'post_id');
    }

}
