<?php

namespace App\Exceptions;

use Exception;

class ForbiddenMessageApprovedDocumentException extends Exception
{

    protected $message = 'Forbidden to send a message on an approved document.';

    protected $code = 400;
}
