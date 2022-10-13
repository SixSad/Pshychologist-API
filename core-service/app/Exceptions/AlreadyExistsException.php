<?php

namespace App\Exceptions;

use Exception;

class AlreadyExistsException extends Exception
{

    protected $message = 'Record already exists';

    protected $code = 400;
}
