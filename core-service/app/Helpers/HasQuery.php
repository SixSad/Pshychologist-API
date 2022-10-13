<?php

declare(strict_types=1);

namespace App\Helpers;

use Egal\Model\Builder;

/**
 * @mixin \Egal\Model\Model
 */
trait HasQuery
{

    public function newQuery(): Builder
    {
        return static::newQuery();
    }

}
