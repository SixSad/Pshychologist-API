<?php

namespace App\Listeners;

use App\Exceptions\NoAccessException;
use App\Helpers\SessionHelper;
use Sixsad\Helpers\AbstractEvent;
use Sixsad\Helpers\AbstractListener;

class DeletingWorkCategoryPsychologistListener extends AbstractListener
{

    public function handle(AbstractEvent $event): void
    {
        $model = $event->getModel();
        if ($model->getAttribute('psychologist_data_id') !== SessionHelper::getUUID()) {
            throw new NoAccessException();
        }
    }

}
