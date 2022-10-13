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
            Session::isActionMessageExists() ?
                sprintf(
                    "Error [%s] was fired with request %s. (%s)",
                    get_class($e),
                    json_encode(Session::getActionMessage()->getParameters()),
                    json_encode($this->convertExceptionToArray($e))

                )
                :  sprintf(
                    "Error %s was fired. %s",
                    json_encode($e),
                    json_encode($this->convertExceptionToArray($e))
                )
        );

        parent::report($e);
    }
}
