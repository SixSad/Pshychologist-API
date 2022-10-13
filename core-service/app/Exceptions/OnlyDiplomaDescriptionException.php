<?php

namespace App\Exceptions;

use Exception;

class OnlyDiplomaDescriptionException extends Exception
{

    protected $message = "The field description must be only for diplomas.";

    protected $code = 400;
}
