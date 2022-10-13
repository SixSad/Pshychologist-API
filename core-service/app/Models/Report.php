<?php

namespace App\Models;

use Carbon\Carbon;
use Egal\Model\Model as EgalModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Support\Collection;

/**
 * @property integer $id                {@property-type field} {@primary-key}
 * @property integer $consultation_id   {@property-type field} {@validation-rules bail|required|int|exists:consultations,id|universal_check_author:consultations,client_id}
 * @property string $message            {@property-type field} {@validation-rules required|max:2000}
 * @property string $category           {@property-type field} {@validation-rules required|enum:insult,condemnation,not_listen,not_competent,violated_confidentiality,not_come,promoted_personal_views,other}
 * @property Carbon $created_at         {@property-type field}
 * @property Carbon $updated_at         {@property-type field}
 *
 * @property Collection $consultation           {@property-type relation}
 * @property Collection $psychologist           {@property-type relation}
 *
 * @action getItems {@statuses-access logged} {@roles-access admin}
 * @action create {@statuses-access logged} {@roles-access user}
 */
class Report extends EgalModel
{
    protected $fillable = [
        "message",
        "consultation_id",
        "category"
    ];

    public function consultation(): BelongsTo
    {
        return $this->belongsTo(Consultation::class);
    }

    public function psychologist(): HasOneThrough {
        return $this->hasOneThrough(User::class, Consultation::class, "id", "id", "consultation_id", "psychologist_id");
    }
}
