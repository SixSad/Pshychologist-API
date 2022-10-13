<?php

namespace App\Exceptions;

use Exception;

class ForbiddenChangeException extends Exception
{

    protected $message = "You cannot edit other people's data.";

    protected $code = 400;
}
