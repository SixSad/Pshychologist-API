<?php

namespace App\Events;

use Sixsad\Helpers\AbstractEvent;
use Egal\Model\Model;
use Sixsad\Helpers\GenerateNumbers;

class SavedUserEvent extends AbstractEvent
{
    public readonly string $code;

    public function __construct(
        Model $model,
        public readonly string $type = "email"
    ) {
        parent::__construct($model);

        $this->code = config("app.debug")
            ? GenerateNumbers::generate(6)
            : 123456;
    }
}
