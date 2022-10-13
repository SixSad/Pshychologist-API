<?php

namespace App\Exceptions;

use Exception;

class ShadowPsychologistRoleException extends Exception
{

    protected $message = 'Incorrect role, the role must be shadow_psychologist.';

    protected $code = 400;
}
