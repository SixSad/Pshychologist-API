<?php

namespace App\Listeners;

use App\Helpers\SessionHelper;
use App\Models\WorkCategoryPsychologist;
use Egal\Core\Session\Session;
use Sixsad\Helpers\AbstractEvent;
use Sixsad\Helpers\AbstractListener;
use Sixsad\Helpers\SessionAttributes;

class ValidatingWorkCategoryPsychologistAttachIdListener extends AbstractListener
{

    public function handle(AbstractEvent $event): void
    {
        $model = $event->getModel();

        if (Session::getActionMessage()->getActionName() === 'createMany') {
            $model->setAttribute('psychologist_data_id', SessionHelper::getUUID());
        }

    }
}
