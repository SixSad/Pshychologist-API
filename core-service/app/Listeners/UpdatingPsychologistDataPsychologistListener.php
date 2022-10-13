<?php

namespace App\Listeners;

use App\Exceptions\NoAccessException;
use App\Helpers\ArrayHelper;
use App\Helpers\SessionHelper;
use Sixsad\Helpers\AbstractEvent;
use Sixsad\Helpers\AbstractListener;
use Sixsad\Helpers\MicroserviceValidator;

class UpdatingPsychologistDataPsychologistListener extends AbstractListener
{

    public function handle(AbstractEvent $event): void
    {
        $model = $event->getModel();

        if($model->getAttribute('id')!== SessionHelper::getUUID()){
            throw new NoAccessException();
        }

        if (SessionHelper::getRole() === 'psychologist') {
            MicroserviceValidator::validate($model->getDirty(), [
                'description' => 'filled|string|max:2000|min:10',
            ]);

            ArrayHelper::arrayFilter($model->getDirty(), ['description']);
        }

        if (SessionHelper::getRole() === 'shadow_psychologist') {
            MicroserviceValidator::validate($model->getDirty(), [
                'description' => 'filled|string|max:2000|min:10',
                'avatar' => 'filled|string',
                'video_link' => 'filled|regex:/http(s?)\:\/\//i'
            ]);

            ArrayHelper::arrayFilter($model->getDirty(), ['description', 'avatar', 'video_link']);
        }

    }

}
