<?php

namespace App\Exceptions;

use Exception;

class InitializeCentryfugoTokenException extends Exception
{

    protected $message = 'Initialize user master refresh token exception!';

    protected $code = 400;
}
