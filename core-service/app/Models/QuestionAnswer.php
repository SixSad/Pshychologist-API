<?php

namespace App\Models;

use Carbon\Carbon;
use Egal\Model\Model as EgalModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;

/**
 * @property integer $id                {@property-type field} {@primary-key}
 * @property integer $user_result_id    {@property-type field} {@validation-rules required|integer|exists:user_results,id}
 * @property integer $question_id       {@property-type field} {@validation-rules required|integer|exists:questions,id}
 * @property integer $answer_option     {@property-type field} {@validation-rules required|integer}
 * @property Carbon $created_at         {@property-type field}
 * @property Carbon $updated_at         {@property-type field}
 *
 * @property Collection $user_result                {@property-type relation}
 * @property Collection $question                   {@property-type relation}
 * @property Collection $answer_option_belong     {@property-type relation}
 *
 * @action getItems {@statuses-access logged} {@roles-access user|psychologist|admin}
 * @action create {@statuses-access logged} {@roles-access admin}
 * @action update {@statuses-access logged} {@roles-access admin}
 * @action delete {@statuses-access logged} {@roles-access admin}
 * @action seederCreate {@services-access auth}
 */
class QuestionAnswer extends EgalModel
{
    use HasFactory;

    protected $fillable = [
        "user_result_id",
        "question_id",
        "answer_option",
    ];

    public static function actionSeederCreate(array $attributes = [])
    {
        self::unsetEventDispatcher();
        $row = new QuestionAnswer();
        $row->user_result_id = $attributes['user_result_id'];
        $row->question_id = $attributes['question_id'];
        $row->answer_option = $attributes['answer_option'];
        $row->save();
        return $row;
    }

    public function userResult(): BelongsTo
    {
        return $this->belongsTo(UserResult::class, 'user_result_id');
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    public function answerOptionBelong(): BelongsTo
    {
        return $this->belongsTo(AnswerOption::class, 'answer_option_id');
    }
}
