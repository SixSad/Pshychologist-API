<?php

namespace App\Models;

use App\Events\DeletingWorkCategoryPsychologistEvent;
use App\Events\ValidatedWorkCategoryPsychologistEvent;
use App\Events\ValidatingWorkCategoryPsychologistEvent;
use App\Helpers\SessionHelper;
use Carbon\Carbon;
use Egal\Core\Session\Session;
use Egal\Model\Model as EgalModel;

/**
 * @property integer $id                    {@property-type field} {@primary-key}
 * @property integer $psychologist_data_id  {@property-type field} {@validation-rules bail|required|uuid|exists:users,id}
 * @property integer $work_category_id      {@property-type field} {@validation-rules bail|required|integer|exists:work_categories,id}
 * @property Carbon $created_at             {@property-type field}
 * @property Carbon $updated_at             {@property-type field}
 *
 * @action getItems {@statuses-access logged} {@roles-access user|psychologist|shadow_psychologist|admin}
 * @action createMany {@statuses-access logged} {@roles-access psychologist|shadow_psychologist}
 * @action deleteMany {@statuses-access logged} {@roles-access psychologist|shadow_psychologist}
 * @action update {@statuses-access logged} {@roles-access admin}
 */
class WorkCategoryPsychologist extends EgalModel
{
    protected $fillable = [
        "work_category_id"
    ];

    protected $dispatchesEvents = [
        'validating' => ValidatingWorkCategoryPsychologistEvent::class,
        'validated' => ValidatedWorkCategoryPsychologistEvent::class,
        'deleting' => DeletingWorkCategoryPsychologistEvent::class
    ];

    public function newQuery()
    {
        if (!Session::isActionMessageExists()) {
            return parent::newQuery();
        }

        if (Session::getActionMessage()->getActionName() === 'getItems' && in_array(SessionHelper::getRole(), ['shadow_psychologist', 'psychologist'])) {
            return parent::newQuery()->where('psychologist_data_id', SessionHelper::getUUID());
        }

        return parent::newQuery();
    }
}
