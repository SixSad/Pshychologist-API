<?php

namespace App\Exceptions;

use Exception;

class VerificatedRequiredDocumentsException extends Exception
{

    protected $message = "At least one diploma or passport must be rejected.";

    protected $code = 400;
}
