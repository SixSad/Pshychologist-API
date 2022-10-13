<?php

namespace App\Exceptions;

use Exception;

class ForbiddenSameStatusException extends Exception
{

    protected $message = "Statuses don't have to match.";

    protected $code = 400;
}
