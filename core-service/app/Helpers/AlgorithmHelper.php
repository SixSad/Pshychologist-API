<?php

namespace App\Helpers;

class AlgorithmHelper
{
    public static function getCategoryGroups(array $pointsCategory): array
    {
        return array_map(fn ($i) => floor((($i / 3) * 100)) / 100, $pointsCategory);
    }

    public static function SortUsersByPoints(&$users): void
    {
        usort($users, fn ($a, $b) => $b["percent"] - $a["percent"]);
    }
}
