<?php

namespace App\Models;

use App\Events\DeletedAnswerOptionEvent;
use Carbon\Carbon;
use Egal\Model\Model as EgalModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @property integer $id                {@property-type field} {@primary-key} {@validation-rules integer|filled}
 * @property string $client_title       {@property-type field} {@validation-rules required|string|min:2|max:255}
 * @property string $psychologist_title {@property-type field} {@validation-rules required|string|min:2|max:255}
 * @property integer $question_id       {@property-type field} {@validation-rules bail|required|integer|exists:questions,id|wrong_question_type}
 * @property Carbon $created_at         {@property-type field}
 * @property Carbon $updated_at         {@property-type field}
 *
 * @property Collection $question_answers           {@property-type relation}
 * @property Collection $question                   {@property-type relation}
 *
 * @action getItems     {@statuses-access logged} {@roles-access user|psychologist|admin}
 * @action create       {@statuses-access logged} {@roles-access admin}
 * @action updateMany   {@statuses-access logged} {@roles-access admin}
 * @action delete       {@statuses-access logged} {@roles-access admin}
 */
class AnswerOption extends EgalModel
{
    use HasFactory;

    protected $fillable = [
        "client_title",
        "psychologist_title",
        "question_id"
    ];

    protected $dispatchesEvents = [
        "deleted" => DeletedAnswerOptionEvent::class,
    ];

    public function questionAnswers(): HasMany
    {
        return $this->hasMany(QuestionAnswer::class, 'answer_option_id');
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}
