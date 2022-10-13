<?php

namespace App\Exceptions;

use Exception;

class NotNullVerificatedException extends Exception
{

    protected $message = "All documents must be approved or rejected.";

    protected $code = 400;
}
