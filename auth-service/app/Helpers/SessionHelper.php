<?php

namespace App\Helpers;

use Egal\Core\Session\Session;

class SessionHelper
{
    public static function getUUID(): string
    {
        return Session::getUserServiceToken()->getUid();
    }

    public static function getRole(): string
    {
        return Session::getUserServiceToken()->getRoles()[0];
    }

    public static function getTimezone(): int
    {
        return Session::getUserServiceToken()->getAuthInformation()['timezone'];
    }
}
