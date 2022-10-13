<?php

namespace App\Exceptions;

use Exception;

class NotFoundEmailException extends Exception
{

    protected $message = 'Email not found!';

    protected $code = 400;
}
