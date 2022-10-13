<?php

namespace App\DebugModels;

use App\Models\Category;

/**
 * @property integer $id                {@property-type field} {@primary-key} {@validation-rules integer|filled}
 * @property string $name               {@property-type field} {@validation-rules required|string|unique:categories|min:3|max:64}
 * @property integer $category_id       {@property-type field} {@validation-rules bail|integer|exists:categories,id|wrong_main_category|self_main_category}
 * @property Carbon $created_at         {@property-type field}
 * @property Carbon $updated_at         {@property-type field}
 *
 * @property Collection $questions              {@property-type relation}
 * @property Collection $categories             {@property-type relation}
 *
 * @action sendMailTestChange {@statuses-access logged} {@roles-access admin}
 * 
 */
class CategoryDebug extends Category
{
    protected $table = "categories";
}
