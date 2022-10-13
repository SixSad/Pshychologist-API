<?php

namespace App\Listeners;

use App\Exceptions\EmptyPasswordException;
use App\Models\Document;
use App\Models\WorkCategoryPsychologist;
use Sixsad\Helpers\AbstractListener;
use Sixsad\Helpers\AbstractEvent;
use Egal\Model\Exceptions\ValidateException;
use Sixsad\Helpers\SessionAttributes;

class SavedPsychologistDataSaveDocumentsListener extends AbstractListener
{
    /**
     * @param AbstractEvent $event
     * @throws EmptyPasswordException
     * @throws ValidateException
     */
    public function handle(AbstractEvent $event): void
    {
        $attributes = SessionAttributes::getAttributes();
        foreach ($attributes['documents'] as $key => $value) {
            Document::actionCreate([
                "photo" => $attributes['documents'][$key]['photo'],
                "description" => $attributes['documents'][$key]['description'] ?? null,
                "type" => $attributes['documents'][$key]['type'],
                "psychologist_data_id" => $event->getModel()->getAttributes()['id'],
            ]);
        }

        foreach ($attributes['work_categories'] as $work_category_id) {
            WorkCategoryPsychologist::actionCreate([
                "psychologist_data_id" => $event->getModel()->getAttributes()['id'],
                "work_category_id" => $work_category_id
            ]);
        }
    }
}
