<?php

namespace App\Listeners;

use App\Models\QuestionAnswer;
use Sixsad\Helpers\AbstractEvent;
use Sixsad\Helpers\AbstractListener;

class DeletedAnswerOptionClearUserResultListener extends AbstractListener
{

    public function handle(AbstractEvent $event): void
    {
        $ao = $event->getModel();

        QuestionAnswer::where([
            "question_id" => $ao->question->id,
            "answer_option" => $ao->getAttribute("id"),
        ])->delete();
    }
}
