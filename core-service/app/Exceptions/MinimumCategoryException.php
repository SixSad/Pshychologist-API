<?php

namespace App\Exceptions;

use Exception;

class MinimumCategoryException extends Exception
{

    protected $message = "You must attach at least one category with type error and method.";

    protected $code = 400;
}
