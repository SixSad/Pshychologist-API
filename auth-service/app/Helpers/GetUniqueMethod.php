<?php

namespace App\Helpers;

use App\Models\User;
use App\Models\WorkCategory;

class GetUniqueMethod
{
    public static function generate($user_id)
    {
        $methods = ["Стресс", "Панические атаки", "Выгорание", "Недостаток мотивации", "Перепады настроения", "Измена", "Насилие", "Утрата близкого человека", "Прокрастинация", "Низкая самооценка", "Сложность с ориентацией", "Финансовые изменения", "Беременность"];
        $word = $methods[random_int(0, count($methods)-1)];
        $request = new \Egal\Core\Communication\Request(
            "core",
            "WorkCategory",
            'getItems',
            [
                "filter" => [
                    [
                        "psychologist_data_id",
                        "eq",
                        $user_id
                    ],
                    "AND",
                    [
                        "title",
                        "eq",
                        $word
                    ]
                ]

            ]
        );
        $request->call();
        $data = $request->getResponse()->getResultData();

        if (!empty($data['items'])) {
            return GetUniqueMethod::generate($user_id);
        }

        return $word;
    }
}
