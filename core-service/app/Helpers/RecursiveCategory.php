<?php

namespace App\Helpers;

use App\Models\Category;

class RecursiveCategory
{
    public static function iteration(int $id, int $category_id): bool
    {
        $new_category_id = Category::query()->find($category_id)->category_id;
        if (is_null($new_category_id)) {
            return true;
        }
        if ($new_category_id === $id) {
            return false;
        }
        return RecursiveCategory::iteration($id,$new_category_id);
    }
}
