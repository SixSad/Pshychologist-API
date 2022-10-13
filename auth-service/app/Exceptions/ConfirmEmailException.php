<?php

namespace App\Exceptions;

use Exception;

class ConfirmEmailException extends Exception
{

    protected $message = 'User not confirm email!';

    protected $code = 405;
}
