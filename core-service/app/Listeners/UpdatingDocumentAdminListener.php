<?php

namespace App\Listeners;

use App\Helpers\ArrayHelper;
use Sixsad\Helpers\AbstractEvent;
use Sixsad\Helpers\AbstractListener;
use Sixsad\Helpers\MicroserviceValidator;

class UpdatingDocumentAdminListener extends AbstractListener
{

    public function handle(AbstractEvent $event): void
    {
        $model = $event->getModel();

        MicroserviceValidator::validate($model->getDirty(), [
            'verified' => 'required|boolean',
            'message' => 'required_if:verified,false|prohibited_if:verified,true|string|min:1|max:2000',
        ]);

        ArrayHelper::arrayFilter($model->getDirty(), ['verified', 'message']);
    }

}
