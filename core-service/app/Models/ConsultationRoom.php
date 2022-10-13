<?php

namespace App\Models;

use App\Events\CreatingConsultationRoomEvent;
use App\Helpers\SessionHelper;
use Carbon\Carbon;
use Egal\Core\Session\Session;
use Egal\Model\Model as EgalModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;

/**
 * @property integer $id                 {@property-type field} {@primary-key}
 * @property integer $consultation_id    {@property-type field}
 * @property string $record_link        {@property-type field}
 * @property Carbon $start_time         {@property-type field}
 * @property Carbon $end_time           {@property-type field}
 * @property Carbon $created_at         {@property-type field}
 * @property Carbon $updated_at         {@property-type field}
 *
 * @property Collection $consultation          {@property-type relation}
 *
 * @action getItems {@statuses-access logged} {@roles-access user|psychologist}
 * @action create   {@services-access core}
 * @action update   {@services-access core}
 */
class ConsultationRoom extends EgalModel
{
    protected $fillable = [
        'consultation_id',
        'room_name',
        'record_link',
        'start_time',
        'end_time',
    ];

    protected $dispatchesEvents = [
        'creating' => CreatingConsultationRoomEvent::class,
    ];

    protected $appends = [
        'display_name',
        'lang'
    ];

    public function newQuery()
    {
        if (!Session::isActionMessageExists()) {
            return parent::newQuery();
        }

        if (Session::getActionMessage()->getActionName() === 'getItems') {
            return parent::newQuery()->whereHas('consultation', function (Builder $query) {
                $query->where('status', '=', 'booked')
                    ->where(function ($query) {
                        $query->where('client_id', '=', SessionHelper::getUUID())
                            ->orWhere('psychologist_id', '=', SessionHelper::getUUID());
                    });
            })->where('end_time', '>', Carbon::now())->where('start_time', '<', Carbon::now()->addMinutes(5));
        }
        return parent::newQuery();
    }

    protected function displayName(): Attribute
    {
        $user = User::query()->find(SessionHelper::getUUID());

        return new Attribute(
            get: fn() => $user->getAttribute('first_name') . ' ' . $user->getAttribute('last_name'),
        );
    }

    protected function lang(): Attribute
    {
        return new Attribute(
            get: fn() => 'ru',
        );
    }

    public function consultation(): BelongsTo
    {
        return $this->belongsTo(Consultation::class);
    }
}
