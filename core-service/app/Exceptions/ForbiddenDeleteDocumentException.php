<?php

namespace App\Exceptions;

use Exception;

class ForbiddenDeleteDocumentException extends Exception
{

    protected $message = "You can only delete documents with the type other";

    protected $code = 400;
}

