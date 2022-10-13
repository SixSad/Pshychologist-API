<?php

namespace App\Listeners;

use App\Exceptions\EmptyPasswordException;
use App\Exceptions\MaxUploadedException;
use App\Helpers\SessionHelper;
use App\Models\PsychologistData;
use App\Models\User;
use Egal\Core\Communication\Request;
use Egal\Model\Exceptions\ObjectNotFoundException;
use Egal\Model\Exceptions\ValidateException;
use Sixsad\Helpers\AbstractEvent;
use Sixsad\Helpers\AbstractListener;
use Sixsad\Helpers\MicroserviceValidator;

class CreateDocumentUploadListener extends AbstractListener
{
    /**
     * @param AbstractEvent $event
     * @throws EmptyPasswordException
     * @throws ValidateException
     * @property User $user
     */
    public function handle(AbstractEvent $event): void
    {
        $model = $event->getModel();
        $model->setAttribute('psychologist_data_id', SessionHelper::getUUID());
        $attributes = $model->getAttributes();

        MicroserviceValidator::validate($attributes, [
            "psychologist_data_id" => "required|exists:psychologist_data,id",
            "photo" => "required|string|blob_url",
            "type" => "required|string|enum:passport,diploma,other",
            "verificated" => "forbidden_change_field",
            "message" => "forbidden_change_field",
        ]);

        if ($attributes["type"] === 'diploma') {
            MicroserviceValidator::validate($attributes, [
                "description" => "required|string|max:2000|min:1"
            ]);
        } else {
            MicroserviceValidator::validate($attributes, [
                "description" => "null"
            ]);
        }

        $documents = PsychologistData::query()->find($attributes["psychologist_data_id"])->documents;

        $diploma_count = 0;
        $other_count = 0;
        foreach ($documents as $document) {
            if ($document->type === 'passport' and $attributes['type'] === 'passport') {
                throw new MaxUploadedException;
            }

            if ($document->type === 'diploma') {
                $diploma_count++;
            }

            if ($document->type === 'other') {
                $other_count++;
            }

        }
        if ($diploma_count >= 3 and $attributes['type'] === 'diploma') {
            throw new MaxUploadedException;
        }

        if ($other_count >= 10 and $attributes['type'] === 'other') {
            throw new MaxUploadedException;
        }
    }
}
