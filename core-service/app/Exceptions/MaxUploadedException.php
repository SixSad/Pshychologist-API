<?php

namespace App\Exceptions;

use Exception;

class MaxUploadedException extends Exception
{

    protected $message = "Maximum number of documents with this type loaded.";

    protected $code = 400;
}

