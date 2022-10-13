<?php

namespace App\Exceptions;

use Exception;

class NotVerificatedRequiredDocumentsException extends Exception
{

    protected $message = "All diplomas and passport must be approved.";

    protected $code = 400;
}
