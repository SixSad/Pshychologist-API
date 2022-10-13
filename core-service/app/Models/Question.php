<?php

namespace App\Models;

use Carbon\Carbon;
use Egal\Core\Session\Session;
use Egal\Model\Model as EgalModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @property integer $id                        {@property-type field} {@primary-key} {@validation-rules integer|filled}
 * @property integer $category_id               {@property-type field} {@validation-rules required|integer|exists:categories,id}
 * @property string $client_title               {@property-type field} {@validation-rules required|string|min:3|max:255}
 * @property string $psychologist_title         {@property-type field} {@validation-rules required|string|min:3|max:255}
 * @property string $type                       {@property-type field} {@validation-rules required|in:one,many|type_reverse|update_question_type}
 * @property bool $psychologist_reverse         {@property-type field} {@validation-rules filled|boolean|type_not_reverse_psychologist}
 * @property bool $client_reverse               {@property-type field} {@validation-rules filled|boolean|type_not_reverse_client}
 * @property Carbon $created_at                 {@property-type field}
 * @property Carbon $updated_at                 {@property-type field}
 *
 * @property Collection $answer_options             {@property-type relation}
 * @property Collection $question_answers           {@property-type relation}
 * @property Collection $category                   {@property-type relation}
 *
 * @action getItems {@statuses-access logged} {@roles-access user|psychologist|admin}
 * @action create {@statuses-access logged} {@roles-access admin}
 * @action update {@statuses-access logged} {@roles-access admin}
 * @action delete {@statuses-access logged} {@roles-access admin}
 */
class Question extends EgalModel
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'client_title',
        'psychologist_title',
        'type',
        'psychologist_reverse',
        'client_reverse'
    ];

    public function newQuery()
    {
        if (!Session::isActionMessageExists()) {
            return parent::newQuery();
        }

        return parent::newQuery()->with(['answer_options']);
    }

    public function answerOptions(): HasMany
    {
        return $this->hasMany(AnswerOption::class);
    }

    public function questionAnswers(): HasMany
    {
        return $this->hasMany(QuestionAnswer::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
