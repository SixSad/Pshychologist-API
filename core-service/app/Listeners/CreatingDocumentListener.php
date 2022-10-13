<?php

namespace App\Listeners;

use App\Exceptions\EmptyPasswordException;
use App\Exceptions\MaxUploadedException;
use App\Helpers\ArrayHelper;
use App\Models\PsychologistData;
use App\Models\User;
use Egal\Model\Exceptions\ValidateException;
use Sixsad\Helpers\AbstractEvent;
use Sixsad\Helpers\AbstractListener;

class CreatingDocumentListener extends AbstractListener
{
    /**
     * @param AbstractEvent $event
     * @throws EmptyPasswordException
     * @throws ValidateException
     * @property User $user
     */
    public function handle(AbstractEvent $event): void
    {
        parent::handle($event);
        $model = $event->getModel();
        $attributes = $model->getAttributes();

        $dataDocument = PsychologistData::query()->find($model->getAttribute('psychologist_data_id'))->documents;

        if ($model->getAttribute('type') === 'diploma') {
            ArrayHelper::arrayFilter($attributes, ['psychologist_data_id', 'photo', 'type', 'description']);
        } else {
            ArrayHelper::arrayFilter($attributes, ['psychologist_data_id', 'photo', 'type']);
        }

        if ($dataDocument->where('type', 'diploma')->count() >= 3
            && $attributes['type'] === 'diploma') {
            throw new MaxUploadedException("Uploaded the maximum number of documents with the type = $model->type");
        }

        if (($dataDocument->where('type', 'passport')->count() >= 1
            && $attributes['type'] === 'passport')) {
            throw new MaxUploadedException("Uploaded the maximum number of documents with the type = $model->type");
        }

        if ($dataDocument->where('type', 'other')->count() >= 10
            && $attributes['type'] === 'other') {
            throw new MaxUploadedException("Uploaded the maximum number of documents with the type = $model->type");
        }

    }
}
