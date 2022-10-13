<?php

namespace App\Listeners;

use App\Exceptions\EmptyPasswordException;
use App\Models\QuestionAnswer;
use Sixsad\Helpers\AbstractListener;
use Sixsad\Helpers\AbstractEvent;
use Egal\Model\Exceptions\ValidateException;
use Sixsad\Helpers\SessionAttributes;

class  SavedUserResultSaveResultTestListener extends AbstractListener
{
    /**
     * @param AbstractEvent $event
     * @throws EmptyPasswordException
     * @throws ValidateException
     */
    public function handle(AbstractEvent $event): void
    {
        $attributes = SessionAttributes::getAttributes();

        foreach ($attributes['answers'] as $key => $value) {
            QuestionAnswer::actionCreate([
                "question_id" => $attributes['answers'][$key]['question_id'],
                "answer_option" => $attributes['answers'][$key]['answer_option'],
                "user_result_id" => $event->getModel()->getAttribute('id'),
            ]);
        }
    }
}
