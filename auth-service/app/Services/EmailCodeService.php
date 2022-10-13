<?php

namespace App\Services;

use App\Helpers\Consts;
use App\Models\EmailCode;
use Carbon\Carbon;

class EmailCodeService
{
    public function __construct(public readonly EmailCode $model)
    {
    }

    public function CheckTimeout(): bool
    {
        $updatedAt = Carbon::parse($this->model->getAttribute("updated_at"))->getTimestamp();

        $now = Carbon::now()->getTimestamp();

        return $now - $updatedAt > Consts::UNIX_DAY;
    }
}
