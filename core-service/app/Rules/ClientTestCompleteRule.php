<?php

namespace App\Rules;


use App\Models\Category;
use App\Models\Question;
use Egal\Core\Session\Session;
use Egal\Validation\Rules\Rule as EgalRule;

class ClientTestCompleteRule extends EgalRule
{
    public function validate($attribute, $value, $parameters = null): bool
    {
        if (Session::getUserServiceToken()->getRoles()[0] !== "user") {
            return true;
        }
        foreach ($value as $item) {
            $category = Category::query()->findOrFail(Question::query()->findOrFail($item['question_id'])->category_id);

            $questions = [];
            foreach ($category->getQuestionsIdsAttribute() as $item2) {
                $questions[] = $item2;
            }

            foreach ($value as $item3) {
                if (in_array($item3['question_id'], $questions)) {
                    unset($questions[array_search($item3['question_id'], $questions)]);
                }
            }
            if (!empty($questions)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return "You must answer all questions from the category.";
    }
}
