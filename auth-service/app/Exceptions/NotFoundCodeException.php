<?php

namespace App\Exceptions;

use Exception;

class NotFoundCodeException extends Exception
{

    protected $message = 'Code not found!';

    protected $code = 400;
}
