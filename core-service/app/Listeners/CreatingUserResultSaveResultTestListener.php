<?php

namespace App\Listeners;

use App\Exceptions\EmptyPasswordException;
use App\Exceptions\TimeOutException;
use App\Helpers\Consts;
use App\Helpers\SessionHelper;
use App\Models\AnswerOption;
use App\Models\Question;
use App\Models\QuestionAnswer;
use App\Models\User;
use App\Models\UserResult;
use Carbon\Carbon;
use Sixsad\Helpers\AbstractListener;
use Sixsad\Helpers\AbstractEvent;
use Sixsad\Helpers\MicroserviceValidator;
use Egal\Model\Exceptions\ValidateException;
use Sixsad\Helpers\SessionAttributes;

class CreatingUserResultSaveResultTestListener extends AbstractListener
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
        $attributes = SessionAttributes::getAttributes();
        $model = $event->getModel();
        $model->setAttribute('user_id', SessionHelper::getUUID());
        $userResult = UserResult::query()->where('user_id', SessionHelper::getUUID())->latest()->first();


        if ($userResult
            && $userResult->getAttribute('created_at') > Carbon::now()->subDays(180)
            && (!Question::query()
                    ->whereBetween("updated_at", [$userResult->getAttribute("created_at"), Carbon::now()])
                    ->exists()
                && !AnswerOption::query()
                    ->whereBetween("updated_at", [$userResult->getAttribute("created_at"), Carbon::now()])
                    ->exists())
        ) {
            throw new TimeOutException();
        }


        MicroserviceValidator::validate($attributes, [
            'answers' => 'bail|required|array|user_result_required|user_result_integer|wrong_question|same_question|answer_option_one|answer_option_gradation|answers_wrong_fields|client_test_complete|psychologist_test_complete',
        ]);

    }
}
