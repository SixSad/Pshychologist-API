<?php

namespace App\Models;

use App\Events\CreatingTimeEvent;
use App\Events\DeletedTimeEvent;
use App\Events\DeletingTimeEvent;
use Carbon\Carbon;
use Egal\Model\Model as EgalModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;

/**
 * @property integer $id                    {@property-type field} {@primary-key}
 * @property integer $schedule_id           {@property-type field} {@validation-rules bail|required|integer|exists:schedules,id|check_author}
 * @property Carbon $time                   {@property-type field} {@validation-rules bail|required|date_format:H:i:s|check_time_after}
 * @property Carbon $created_at             {@property-type field}
 * @property Carbon $updated_at             {@property-type field}
 *
 * @property Collection $schedule           {@property-type relation}
 *
 * @action createMany {@statuses-access logged} {@roles-access psychologist}
 * @action deleteMany {@statuses-access logged} {@roles-access psychologist}
 */
class Time extends EgalModel
{
    use HasFactory;

    protected int $maxCountEntitiesToProcess = 169;

    protected $fillable = [
        "schedule_id",
        "time"
    ];

    protected $dispatchesEvents = [
        "creating" => CreatingTimeEvent::class,
        "deleting" => DeletingTimeEvent::class,
        "deleted" => DeletedTimeEvent::class,
    ];

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }
}
