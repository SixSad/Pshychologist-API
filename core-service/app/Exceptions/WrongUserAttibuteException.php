<?php

namespace App\Exceptions;

use Exception;

class WrongUserAttibuteException extends Exception
{

    protected $message = 'Only user fields can be filled.';

    protected $code = 400;
}
