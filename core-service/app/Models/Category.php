<?php

namespace App\Models;

use Carbon\Carbon;
use Egal\Core\Session\Session;
use Egal\Model\Model as EgalModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @property integer $id                {@property-type field} {@primary-key} {@validation-rules integer|filled}
 * @property string $name               {@property-type field} {@validation-rules required|string|unique:categories|min:3|max:64}
 * @property integer $category_id       {@property-type field} {@validation-rules bail|exists:categories,id|wrong_main_category|self_main_category}
 * @property Carbon $created_at         {@property-type field}
 * @property Carbon $updated_at         {@property-type field}
 *
 * @property Collection $questions              {@property-type relation}
 * @property Collection $categories             {@property-type relation}
 *
 * @action getItems {@statuses-access logged} {@roles-access user|psychologist|admin}
 * @action create {@statuses-access logged} {@roles-access admin}
 * @action update {@statuses-access logged} {@roles-access admin}
 * @action delete {@statuses-access logged} {@roles-access admin}
 */
class Category extends EgalModel
{
    use HasFactory;

    protected $fillable = [
        "name",
        "category_id"
    ];

    public function newQuery()
    {
        if (!Session::isActionMessageExists()) {
            return parent::newQuery();
        }

        return parent::newQuery()->with(['categories', 'questions']);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function getQuestionsIdsAttribute()
    {
        return $this->questions->pluck('id');
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class, 'category_id', 'id');
    }
}
