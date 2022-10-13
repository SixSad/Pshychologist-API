<?php

namespace App\Models;

use Carbon\Carbon;
use Egal\Model\Model as EgalModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

/**
 * @property integer $id                    {@property-type field} {@primary-key}
 * @property string $title                  {@property-type field}
 * @property string $type                   {@property-type field}
 * @property Carbon $created_at             {@property-type field}
 * @property Carbon $updated_at             {@property-type field}
 *
 *  @property Collection $psychologist_data               {@property-type relation}
 *
 * @action getItems {@statuses-access logged} {@services-access auth}
 * @action create {@statuses-access logged} {@roles-access admin}
 * @action update {@statuses-access logged} {@roles-access admin}
 * @action delete {@statuses-access logged} {@roles-access admin}
 */
class WorkCategory extends EgalModel
{
    use HasFactory;

    protected $keyType = 'string';

    protected $fillable = [
        "type",
        "title",
    ];

    public function psychologistData(): BelongsToMany
    {
        return $this->belongsToMany(PsychologistData::class, 'psychologist_data_id');
    }
}
