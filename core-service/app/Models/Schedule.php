<?php

namespace App\Models;

use App\Events\RetrievedScheduleEvent;
use App\Events\UpdatingScheduleEvent;
use App\Helpers\SessionHelper;
use Carbon\Carbon;
use Egal\Core\Session\Session;
use Egal\Model\Model as EgalModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;


/**
 * @property integer $id               {@property-type field} {@primary-key} {@validation-rules integer|filled}
 * @property string $psychologist_id   {@property-type field}
 * @property string $week_day          {@property-type field}
 * @property string $expiration_date   {@property-type field} {@validation-rules date_format:Y-m-d|after:today}
 * @property Carbon $created_at        {@property-type field}
 * @property Carbon $updated_at        {@property-type field}
 *
 * @property Collection $user           {@property-type relation}
 * @property Collection $psychologist_data   {@property-type relation}
 *
 * @action getItems         {@statuses-access logged}       {@roles-access user|psychologist|admin}
 * @action updateMany       {@status-access logged}         {@roles-access psychologist}
 */
class Schedule extends EgalModel
{
    use HasFactory;

    protected $fillable = [
        'psychologist_id',
        'week_day',
        'expiration_date'
    ];

    protected $dispatchesEvents = [
        'retrieved.action' => RetrievedScheduleEvent::class,
        'updating' => UpdatingScheduleEvent::class
    ];

    public function newQuery()
    {

        if (!Session::isActionMessageExists()) {
            return parent::newQuery();
        }

        if (Session::getActionMessage()->getActionName() === 'getItems' && SessionHelper::getRole() === 'psychologist') {

            return parent::newQuery()->where('psychologist_id', SessionHelper::getUUID());
        }

        return parent::newQuery();
    }

    public function times(): HasMany
    {
        return $this->hasMany(Time::class);
    }

    public function psychologistData(): BelongsTo
    {
        return $this->belongsTo(PsychologistData::class, 'psychologist_id', 'id');
    }
}
