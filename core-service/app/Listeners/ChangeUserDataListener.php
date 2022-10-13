<?php

namespace App\Listeners;

use App\Exceptions\MinimumCategoryException;
use App\Helpers\SessionHelper;
use App\Models\Document;
use App\Models\PsychologistData;
use App\Models\WorkCategory;
use App\Models\WorkCategoryPsychologist;
use Illuminate\Support\Facades\DB;
use PHPUnit\Util\Exception;
use Sixsad\Helpers\AbstractEvent;
use Sixsad\Helpers\AbstractListener;
use Sixsad\Helpers\MicroserviceValidator;
use Sixsad\Helpers\SessionAttributes;
use Throwable;

class ChangeUserDataListener extends AbstractListener
{

    public function handle(AbstractEvent $event): void
    {
        parent::handle($event);
        $user = $event->getModel();
        $attributes = SessionAttributes::getAttributes();

        MicroserviceValidator::validate($attributes, [
            'data' => 'filled|array',
            'documents' => 'filled|array',
            'work_categories' => 'filled|array'
        ]);

        $work_categories = collect(SessionAttributes::getAttributes()['work_categories'])->pluck('work_category_id');

        if (!WorkCategory::query()->whereIn('id', $work_categories)->where('type', 'error')->exists()
            || !WorkCategory::query()->whereIn('id', $work_categories)->where('type', 'method')->exists()) {
            throw new MinimumCategoryException();
        }

        try {
            DB::beginTransaction();
            if (isset($attributes['data'])) {
                PsychologistData::actionUpdate($user->getAttribute('id'), $attributes['data']);
            }

            if (isset($attributes['documents'])) {
                Document::actionUpdateMany($attributes['documents']);
            }

            if (isset($attributes['work_categories'])) {
                $categories = WorkCategoryPsychologist::query()->where('psychologist_data_id', SessionHelper::getUUID())->pluck('id')->toArray();
                WorkCategoryPsychologist::actionDeleteMany($categories);
                WorkCategoryPsychologist::actionCreateMany($attributes['work_categories']);
            }
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            throw new Exception($e->getMessage(), $e->getCode());
        }
    }

}
