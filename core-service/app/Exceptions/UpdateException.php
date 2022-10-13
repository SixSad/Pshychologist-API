<?php

namespace App\Exceptions;

use Exception;

class UpdateException extends Exception
{

    protected $message = 'Entity update exception';

    protected $code = 400;
}
