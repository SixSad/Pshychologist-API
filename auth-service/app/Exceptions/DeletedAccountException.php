<?php

namespace App\Exceptions;

use Exception;

class DeletedAccountException extends Exception
{

    protected $message = 'User account are blocked!';

    protected $code = 405;
}
