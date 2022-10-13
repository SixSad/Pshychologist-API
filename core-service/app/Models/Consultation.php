<?php

namespace App\Models;

use App\Events\CreatedConsultationEvent;
use App\Events\CreatingConsultationEvent;
use App\Events\RetrievedConsultationEvent;
use App\Events\UpdatedConsultationEvent;
use App\Events\UpdatingConsultationEvent;
use App\Events\ValidatingConsultationEvent;
use App\Helpers\SessionHelper;
use Carbon\Carbon;
use Egal\Core\Session\Session;
use Egal\Model\Model as EgalModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @property integer $id                    {@property-type field} {@primary-key}
 * @property Carbon $date                   {@property-type field} {@validation-rules bail|required|date_format:Y-m-d H:00:00|check_time_before:12|unique_consultation|check_time|check_schedule}
 * @property string $client_id              {@property-type field} {@validation-rules bail|required|uuid|exists:users,id|consultation_check_client}
 * @property string $psychologist_id        {@property-type field} {@validation-rules bail|required|uuid|exists:users,id|check_psychologist}
 * @property string $status                 {@property-type field} {@validation-rules bail|required|string|in:booked,canceled,perform}
 * @property Carbon $created_at             {@property-type field}
 * @property Carbon $updated_at             {@property-type field}
 *
 * @property Collection $consultation_room          {@property-type relation}
 * @property Collection $psychologist               {@property-type relation}
 * @property Collection $client                     {@property-type relation}
 * @property Collection $reports                    {@property-type relation}
 *
 * @action getItems {@statuses-access logged} {@roles-access user|psychologist|admin}
 * @action create {@statuses-access logged} {@roles-access user}
 * @action update {@statuses-access logged} {@roles-access user|psychologist}
 */
class Consultation extends EgalModel
{
    protected $fillable = [
        'date',
        'psychologist_id',
        'client_id',
        'status'
    ];

    protected $dispatchesEvents = [
        'retrieved.action' => RetrievedConsultationEvent::class,
        'validating.action' => ValidatingConsultationEvent::class,
        'creating' => CreatingConsultationEvent::class,
        'created' => CreatedConsultationEvent::class,
        'updating' => UpdatingConsultationEvent::class,
        'updated' => UpdatedConsultationEvent::class
    ];

    public function newQuery()
    {
        if (!Session::isActionMessageExists()) {
            return parent::newQuery();
        }

        if (Session::getActionMessage()->getActionName() === 'getItems' && SessionHelper::getRole() !== 'admin') {
            return parent::newQuery()->with(['client', 'psychologist'])->where('client_id', SessionHelper::getUUID())->orWhere('psychologist_id', SessionHelper::getUUID());
        }

        return parent::newQuery()->with(['client', 'psychologist']);
    }

    public function reports(): hasMany
    {
        return $this->hasMany(Report::class, 'consultation_id');
    }

    public function consultationRoom(): hasMany
    {
        return $this->hasMany(ConsultationRoom::class, 'consultation_id');
    }

    public function psychologist(): BelongsTo
    {
        return $this->belongsTo(User::class, 'psychologist_id');
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id');
    }
}
