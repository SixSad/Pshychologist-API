<?php

namespace App\Events;

use App\Models\PsychologistData;
use Sixsad\Helpers\AbstractEvent;
use Sixsad\Helpers\SessionAttributes;

class CreatingPsychologistDataEvent extends AbstractEvent
{
    public PsychologistData $psychologistData;
    public array $attributes;

    /**
     * @param PsychologistData $userResult
     */
    public function __construct(PsychologistData $psychologistData)
    {
        parent::__construct($psychologistData);
        $this->psychologistData = $psychologistData;
        $this->attributes = SessionAttributes::getAttributes();
    }
}
