<?php

namespace App\Exceptions;

use Exception;

class NoAccessException extends Exception
{

    protected $message = 'Forbidden for you';

    protected $code = 403;
}
