<?php

namespace App\Exceptions;

use Exception;

class WorkCategoryNotExistException extends Exception
{

    protected $message = "Work category does not exist.";

    protected $code = 400;

}
