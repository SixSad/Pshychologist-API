<?php

namespace App\Exceptions;

use Exception;

class UnableToCreateException extends Exception
{

    protected $message = 'Unable to create';

    protected $code = 400;
}
