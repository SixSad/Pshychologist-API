<?php

namespace App\Models;

use App\Events\CreatingDocumentEvent;
use App\Events\DeleteDocumentEvent;
use App\Events\UpdatingDocumentEvent;
use App\Events\ValidatingDocumentEvent;
use App\Helpers\SessionHelper;
use Carbon\Carbon;
use Egal\Core\Session\Session;
use Egal\Model\Model as EgalModel;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;

/**
 * @property integer $id                        {@property-type field} {@primary-key} {@validation-rules filled|integer}
 * @property string $psychologist_data_id       {@property-type field}  {@validation-rules filled|exists:psychologist_data,id}
 * @property string $photo                      {@property-type field}  {@validation-rules required|string}
 * @property string $type                       {@property-type field}  {@validation-rules required|string|in:passport,diploma,other}
 * @property string $description                {@property-type field}  {@validation-rules required_if:type,diploma|string|max:2000|min:1}
 * @property string $verified                   {@property-type field}
 * @property string $message                    {@property-type field}
 * @property Carbon $created_at                 {@property-type field}
 * @property Carbon $updated_at                 {@property-type field}
 *
 * @property Collection psychologist_data       {@property-type relation}
 *
 * @action getItems {@statuses-access logged}       {@roles-access user|psychologist|shadow_psychologist|admin}
 * @action createMany {@statuses-access logged}     {@roles-access psychologist|shadow_psychologist}
 * @action updateMany {@statuses-access logged}     {@roles-access shadow_psychologist|psychologist|admin}
 * @action deleteMany {@statuses-access logged}     {@roles-access psychologist|shadow_psychologist}
 */
class Document extends EgalModel
{
    use HasFactory;

    protected int $maxCountEntitiesToProcess = 13;

    protected $fillable = [
        "photo",
        "psychologist_data_id",
        "description",
        "type",
        "verified",
        "message"
    ];

    protected $dispatchesEvents = [
        'validating' => ValidatingDocumentEvent::class,
        'updating' => UpdatingDocumentEvent::class,
        'creating' => CreatingDocumentEvent::class,
        'deleting' => DeleteDocumentEvent::class
    ];

    protected function photo(): Attribute
    {
        return new Attribute(
            get: fn($value) => gettype($value) === 'string' ? $value : stream_get_contents($value),
            set: fn($value) => gettype($value) === 'resource' ? $value : (string)$value
        );
    }

    public function newQuery()
    {
        if (!Session::isActionMessageExists()) {
            return parent::newQuery();
        }

        if (Session::getActionMessage()->getActionName() === 'getItems' && SessionHelper::getRole() === 'user') {
            return parent::newQuery()->select('id', 'psychologist_data_id', 'description')->where([
                'verified' => true,
                'type' => 'diploma'
            ]);
        }

        if (Session::getActionMessage()->getActionName() === 'getItems' && in_array(SessionHelper::getRole(), ['psychologist', 'shadow_psychologist'])) {
            return parent::newQuery()->where('psychologist_data_id', SessionHelper::getUUID());
        }

        return parent::newQuery();
    }

    public function psychologistData(): BelongsTo
    {
        return $this->belongsTo(PsychologistData::class, 'psychologist_data_id');
    }
}
