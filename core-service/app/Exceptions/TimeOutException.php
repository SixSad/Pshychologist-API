<?php

namespace App\Exceptions;

use Exception;

class TimeOutException extends Exception
{

    protected $message = 'DateTime exception';

    protected $code = 400;
}
