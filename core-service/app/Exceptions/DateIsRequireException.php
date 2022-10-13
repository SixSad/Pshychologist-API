<?php

namespace App\Exceptions;

use Exception;

class DateIsRequireException extends Exception
{

    protected $message = 'The date field is required.';

    protected $code = 400;
}
