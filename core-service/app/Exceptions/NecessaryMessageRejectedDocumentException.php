<?php

namespace App\Exceptions;

use Exception;

class NecessaryMessageRejectedDocumentException extends Exception
{

    protected $message = 'Necessary to send a message on an rejected document';

    protected $code = 400;
}
