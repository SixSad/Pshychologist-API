<?php

namespace App\DebugModels;

use App\Models\Category;
use App\Models\Notification;

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
 * @action testStartNotifications {@statuses-access guest}
 * 
 */
class NotificationDebugModel extends Notification
{
    protected $table = "notifications";
}
