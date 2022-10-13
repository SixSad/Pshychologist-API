<?php

namespace App\Listeners;

use App\Exceptions\EmptyPasswordException;
use App\Exceptions\PsychologistDataAlreadyExistsException;
use App\Helpers\SessionHelper;
use App\Models\PsychologistData;
use Sixsad\Helpers\AbstractListener;
use Sixsad\Helpers\AbstractEvent;
use Egal\Model\Exceptions\ValidateException;

class CreatingPsychologistDataSaveDataListener extends AbstractListener
{
    /**
     * @param AbstractEvent $event
     * @throws EmptyPasswordException
     * @throws ValidateException
     */
    public function handle(AbstractEvent $event): void
    {
        parent::handle($event);
        $data = $event->getModel();
        $data->setAttribute('id', SessionHelper::getUUID());

        if (PsychologistData::query()->where('id', $data->getAttribute('id'))->exists()) {
            throw new PsychologistDataAlreadyExistsException();
        }

    }
}
