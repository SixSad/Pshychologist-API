<?php

namespace App\Exceptions;

use Egal\Core\Exceptions\ExceptionHandler as EgalExceptionHandler;
use Egal\Core\Session\Session;
use Illuminate\Support\Facades\Log;
use Throwable;

class Handler extends EgalExceptionHandler
{

    public function report(Throwable $e)
    {
        Log::error(
            sprintf(
                "Error [%s] was fired with request [%s]. (%s)",
                [
                    get_class($this),
                    Session::getActionMessage()->toArray(),
                    $this->convertExceptionToArray($e),
                ]
            )
        );

        parent::report($e);
    }
}
