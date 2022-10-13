<?php

namespace App\Exceptions;

use Exception;

class PsychologistDataAlreadyExistsException extends Exception
{

    protected $message = 'PsychologistData already exists.';

    protected $code = 400;
}
