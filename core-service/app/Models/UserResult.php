<?php

namespace App\Models;

use App\Events\CreatingUserResultEvent;
use App\Events\SavedUserResultEvent;
use App\Exceptions\NoAccessException;
use App\Helpers\AlgorithmHelper;
use App\Helpers\ArrayHelper;
use App\Helpers\SessionHelper;
use App\Helpers\SqlHelper;
use Carbon\Carbon;
use Egal\Core\Session\Session;
use Egal\Model\Model as EgalModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use League\Flysystem\Exception;

/**
 * @property integer $id                        {@property-type field} {@primary-key}
 * @property integer $user_result_id            {@property-type field}
 * @property integer $question_id               {@property-type field}
 * @property integer $answer_option             {@property-type field}
 * @property Carbon $created_at                {@property-type field}
 * @property Carbon $updated_at                {@property-type field}
 *
 * @property Collection $user                        {@property-type relation}
 * @property Collection $question_answers            {@property-type relation}
 *
 * @action getItems             {@statuses-access logged}       {@roles-access user|psychologist|admin}
 * @action create               {@statuses-access logged}       {@roles-access user|psychologist}
 * @action getMyPsychologists   {@statuses-access logged}       {@roles-access user}
 */
class UserResult extends EgalModel
{
    use HasFactory;

    protected $guarder = [
        'created_at',
        'updated_at',
    ];

    protected $dispatchesEvents = [
        'creating' => CreatingUserResultEvent::class,
        'saved' => SavedUserResultEvent::class,
    ];

    public static function actionGetMyPsychologists(): array
    {
        $id = SessionHelper::getUUID();

        if (!$id || !User::query()->find($id)) {
            throw new NoAccessException();
        }

        $questionAnswersUser = User::where("id", $id)->has("latestUserResult")->exists();

        if (!$questionAnswersUser) {
            throw new Exception("The client needs to pass the test", 405);
        }

        $client = SqlHelper::getUserResultById($id);

        $questionIds = array_map(fn ($item) => $item->question_id, $client);

        $questions = Question::whereIn("id", $questionIds)->get()->toArray();
        $psyResult = SqlHelper::getPsyResult($questionIds);

        $groupPsy = ArrayHelper::arrayGroup("id", $psyResult);

        $pointsPerCategory = [];
        $singleQuestions = [];
        $clientCategories = [];

        foreach ($client as $answer) {
            $answer = (array)$answer;
            $questionId = $answer['question_id'];
            $answerOption = $answer['answer_option'];

            $question = ArrayHelper::arrayFind($questions, fn ($item) => $item["id"] == $questionId);

            if (array_key_exists($question['category_id'], $clientCategories)) {
                $clientCategories[$question['category_id']] += $question["client_reverse"] === true
                    ? 4 - $answerOption
                    : $answerOption;
                $pointsPerCategory[$question['category_id']] += 4;
            } elseif ($question && $question['type'] === "many") {
                $clientCategories[$question['category_id']] = $question["client_reverse"] === true
                    ? 4 - $answerOption
                    : $answerOption;
                $pointsPerCategory[$question['category_id']] = 4;
            } else {
                $singleQuestions[$questionId] = $answerOption;
            }
        }

        $categoryGroups = AlgorithmHelper::getCategoryGroups($pointsPerCategory);

        $client = [];

        foreach ($clientCategories as $key => $item) {
            $group = 0;

            if ($categoryGroups[$key] > 0) {
                $floor = floor($item / $categoryGroups[$key]) + 1;

                $group = $floor === (float)4 ? 3 : $floor;
            } else {
                $group = $item;
            }

            $client[$key] = $group;
        }
        $groupPsy = array_map(function ($item) use ($questions, $categoryGroups, $client, $singleQuestions) {
            $psyCategory = [];
            $singleQuestionsPsy = [];

            foreach ($item as $answer) {
                $answer = (array)$answer;
                $questionId = $answer['question_id'];
                $answerOption = $answer['answer_option'];

                $question = ArrayHelper::arrayFind($questions, fn ($item) => $item["id"] == $questionId);
                if (array_key_exists($question['category_id'], $psyCategory)) {
                    $psyCategory[$question['category_id']] += $question["psychologist_reverse"] === true
                        ? 4 - $answerOption
                        : $answerOption;
                } elseif ($question && $question['type'] === "many") {
                    $psyCategory[$question['category_id']] = $question["psychologist_reverse"] === true
                        ? 4 - $answerOption
                        : $answerOption;
                } else {
                    $singleQuestionsPsy[$questionId] = $answerOption;
                }
            }

            $matches = 0;

            foreach ($singleQuestions as $key => $item) {
                if ($item == $singleQuestionsPsy[$key]) {
                    $matches += 1;
                }
            }

            foreach ($psyCategory as $key => $item) {
                $group = 0;

                if ($categoryGroups[$key] > 0) {
                    $floor = floor($item / $categoryGroups[$key]) + 1;

                    $group = $floor === (float)4 ? 3 : $floor;
                } else {
                    $group = $item;
                }

                if ((int)$client[$key] === (int)$group) {
                    $matches += 1;
                }
            }

            return ($matches / (count($psyCategory) + count($singleQuestions))) * 100;
        }, $groupPsy);

        $psychologists = User::whereIn("id", array_keys($groupPsy))->with([
            "psychologistData",
            "psychologistData.workCategories"
        ])->get()->toArray();

        $psychologistsWithPoints = array_map(function ($item) use ($groupPsy) {
            return $item + ["percent" => $groupPsy[$item['id']]];
        }, $psychologists);

        AlgorithmHelper::SortUsersByPoints($psychologistsWithPoints);

        return $psychologistsWithPoints;
    }

    public function newQuery()
    {
        if (!Session::isActionMessageExists()) {
            return parent::newQuery();
        }

        if (Session::getActionMessage()->getActionName() === 'getItems' && SessionHelper::getRole() !== 'admin') {
            return parent::newQuery()->with('questionAnswers')->where('user_id', SessionHelper::getUUID())->latest();
        }

        return parent::newQuery()->with('questionAnswers')->latest();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function questionAnswers(): HasMany
    {
        return $this->hasMany(QuestionAnswer::class, 'user_result_id');
    }
}
