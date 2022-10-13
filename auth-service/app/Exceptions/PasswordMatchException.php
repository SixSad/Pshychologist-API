<?php

namespace App\Exceptions;

use Exception;

class PasswordMatchException extends Exception
{

    protected $message = 'Passwords dont match!';

    protected $code = 400;
}
