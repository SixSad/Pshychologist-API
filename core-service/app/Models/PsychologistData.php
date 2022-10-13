<?php

namespace App\Models;

use App\Events\ChangeUserDataEvent;
use App\Events\CreatingPsychologistDataEvent;
use App\Events\RetrievedPsychologistDataEvent;
use App\Events\UpdatingPsychologistDataEvent;
use App\Helpers\SessionHelper;
use Carbon\Carbon;
use Egal\Core\Session\Session;
use Egal\Model\Model as EgalModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @property string $id                {@property-type field} {@primary-key} {@validation-rules filled|uuid}
 * @property string $avatar            {@property-type field}   {@validation-rules required|string}
 * @property integer $experience       {@property-type field}   {@validation-rules required|integer|min:0|max:75}
 * @property string $description       {@property-type field}   {@validation-rules required|string|max:2000}
 * @property string $video_link        {@property-type field}   {@validation-rules required|string|unique:psychologist_data,video_link|max:255|regex:/http(s?)\:\/\//i}
 * @property Carbon $created_at        {@property-type field}
 * @property Carbon $updated_at        {@property-type field}
 *
 * @property Collection $user               {@property-type relation}
 * @property Collection $documents          {@property-type relation}
 * @property Collection $work_categories    {@property-type relation}
 * @property Collection $schedules          {@property-type relation}
 *
 * @action getItems {@statuses-access logged} {@roles-access user|psychologist|admin}
 * @action create {@statuses-access logged} {@roles-access shadow_psychologist}
 * @action update {@statuses-access logged} {@roles-access shadow_psychologist|psychologist|admin}
 * @action delete {@statuses-access logged} {@roles-access admin}
 * @action changeMyData {@statuses-access logged} {@roles-access shadow_psychologist|psychologist}
 */
class PsychologistData extends EgalModel
{
    use HasFactory;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        "id",
        "avatar",
        "experience",
        "description",
        "video_link"
    ];

    protected $dispatchesEvents = [
        'creating' => CreatingPsychologistDataEvent::class,
        'updating' => UpdatingPsychologistDataEvent::class
    ];

    public function newQuery()
    {
        if (!Session::isActionMessageExists()) {
            return parent::newQuery();
        }

        if (Session::getActionMessage()->getModelName() !== get_class_short_name($this)) {
            return parent::newQuery();
        }

        if (Session::getActionMessage()->getActionName() === 'getItems' && in_array(SessionHelper::getRole(), ['psychologist', 'shadow_psychologist'])) {
            return parent::newQuery()->with(['documents', 'workCategories'])->where('id', SessionHelper::getUUID());
        }

        return parent::newQuery()->with(['user','documents', 'workCategories']);
    }

    protected function avatar(): Attribute
    {
        return new Attribute(
            get: fn($value) => gettype($value) === 'string' ? $value : stream_get_contents($value),
        );
    }

    public static function actionChangeMyData($attributes): array
    {
        $user = User::query()->find(SessionHelper::getUUID());
        event(new ChangeUserDataEvent($user));
        $psyData = PsychologistData::query()->with(['documents', 'workCategories'])->find(SessionHelper::getUUID());

        return $psyData->toArray();
    }


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class, 'psychologist_data_id');
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class, 'psychologist_id', 'id');
    }

    public function workCategories(): belongsToMany
    {
        return $this->belongsToMany(WorkCategory::class, 'work_category_psychologists', "psychologist_data_id", "work_category_id");
    }
}
