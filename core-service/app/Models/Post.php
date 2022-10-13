<?php

namespace App\Models;

use App\Events\PostDeletingEvent;
use App\Events\PostUpdatingEvent;
use App\Events\PostValidatingEvent;
use Carbon\Carbon;
use Egal\Model\Model as EgalModel;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @property int $id                    {@property-type field}  {@prymary-key}
 * @property string $user_id            {@property-type field}  {@validation-rules required|uuid|exists:users,id}
 * @property string $title              {@property-type field}  {@validation-rules required|string}
 * @property string $body               {@property-type field}  {@validation-rules required|min:10|max:1000}
 * @property string $category           {@property-type field}  {@validation-rules required|in:blog,lecture,other}
 * @property Carbon $created_at         {@property-type field}
 * @property Carbon $updated_at         {@property-type field}
 *
 * @property Collection $comments       {@property-type relation}
 * @property Collection $likes          {@property-type relation}
 *
 * @action getItem          {@statuses-access guest|logged}
 * @action getItems         {@statuses-access guest|logged}
 * @action create           {@statuses-access logged} {@roles-access admin|psychologist}
 * @action update           {@statuses-access logged} {@roles-access admin|psychologist}
 * @action deleteMany       {@statuses-access logged} {@roles-access admin|psychologist}
 */
class Post extends EgalModel
{
    protected $fillable = [
        'user_id',
        'title',
        'body',
        'category'
    ];

    protected $dispatchesEvents = [
        'validating' => PostValidatingEvent::class,
        'updating' => PostUpdatingEvent::class,
        'deleting' => PostDeletingEvent::class
    ];

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'post_id')->where('comment_id', '=', null);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class, 'post_id');
    }
}
