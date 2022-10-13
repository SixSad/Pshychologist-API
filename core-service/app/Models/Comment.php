<?php

namespace App\Models;

use App\Events\CommentDeletingEvent;
use App\Events\CommentUpdatingEvent;
use App\Events\CommentValidatingEvent;
use Carbon\Carbon;
use Egal\Model\Model as EgalModel;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;

/**
 * @property int $id                {@property-type field} {@prymary-key}
 * @property int $post_id           {@property-type field} {@validation-rules required|int|exists:posts,id}
 * @property string $user_id        {@property-type field} {@validation-rules required|uuid|exists:users,id}
 * @property string $body           {@property-type field} {@validation-rules required|string|max:120}
 * @property int $comment_id        {@property-type field} {@validation-rules filled|int|exists:comments,id}
 * @property Carbon $created_at     {@property-type field}
 * @property Carbon $updated_at     {@property-type field}
 *
 * @property Collection $post                   {@property-type relation}
 * @property Collection $nested_comments        {@property-type relation}
 *
 * @action getItem      {@statuses-access guest|logged}
 * @action getItems     {@statuses-access guest|logged}
 * @action create       {@statuses-access logged} {@roles-access user|psychologist|admin}
 * @action update       {@statuses-access logged} {@roles-access user|psychologist|admin}
 * @action delete       {@statuses-access logged} {@roles-access user|psychologist|admin}
 */
class Comment extends EgalModel
{
    protected $fillable = [
        'post_id',
        'user_id',
        'body',
        'comment_id'
    ];

    protected $dispatchesEvents = [
        'validating' => CommentValidatingEvent::class,
        'updating' => CommentUpdatingEvent::class,
        'deleting' => CommentDeletingEvent::class
    ];

    public function post(): HasOne
    {
        return $this->hasOne(Post::class, 'post_id');
    }

    public function nestedComments(): HasMany
    {
        return $this->hasMany(Comment::class, 'comment_id');
    }

}
