<?php

namespace App\Listeners;

use App\Exceptions\MinimumCategoryException;
use App\Helpers\SessionHelper;
use App\Models\WorkCategory;
use App\Models\WorkCategoryPsychologist;
use Egal\Core\Session\Session;
use Sixsad\Helpers\AbstractEvent;
use Sixsad\Helpers\AbstractListener;
use Sixsad\Helpers\SessionAttributes;

class ValidatedWorkCategoryPsychologistListener extends AbstractListener
{

    public function handle(AbstractEvent $event): void
    {
        $model = $event->getModel();
        if (WorkCategoryPsychologist::query()->where([
            'psychologist_data_id' => SessionHelper::getUUID(),
            'work_category_id' => $model->getAttribute('work_category_id')
        ])->exists()) {
            throw new \Exception("Work category id $model->work_category_id already exists", 405);
        }

        $work_categories = collect(Session::getActionMessage()->getParameters()['objects'])
            ->pluck('work_category_id');

        if (!WorkCategoryPsychologist::query()->where('psychologist_data_id',SessionHelper::getUUID())->exists()
            && !WorkCategory::query()->whereIn('id', $work_categories)->where('type', 'error')->exists()
            || !WorkCategory::query()->whereIn('id', $work_categories)->where('type', 'method')->exists()) {
            throw new MinimumCategoryException();
        }

    }
}
