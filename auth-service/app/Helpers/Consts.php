<?php

namespace App\Helpers;

class Consts
{
    public const TYPE_EMAIL = 'email';
    public const TYPE_PASSWORD = 'password';

    public const STATUS_CONFIRM  = 'confirmed';
    public const STATUS_EXPECT  = 'expected';
    public const STATUS_BLOCK  = 'blocked';

    public const STATUSES = [
        self::TYPE_EMAIL => self::STATUS_EXPECT,
        self::TYPE_PASSWORD => self::STATUS_CONFIRM
    ];

    public const MAIL_SUBJECT = [
        self::TYPE_EMAIL => "Подтверждение почты",
        self::TYPE_PASSWORD => "Восстановление пароля",
    ];
    public const MAIL_TEXT = [
        self::TYPE_EMAIL => "регистрации",
        self::TYPE_PASSWORD => "восстановления пароля",
    ];

    public const UNIX_DAY = 86400;
}
