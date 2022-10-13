<?php

namespace App\Helpers;

class Consts
{
    public const STATUS_BOOKED = 'booked';
    public const STATUS_PERFORM = 'perform';
    public const STATUS_CANCELED = 'canceled';

    public const QUESTION_TYPE_ONE = 'one';
    public const QUESTION_TYPE_MANY = 'many';

    public const EMAIL_SUBJECT_NEW = 'Новая консультация';
    public const EMAIL_SUBJECT_RESCHEDULE = 'Перенос консультации';
    public const EMAIL_SUBJECT_CANCELED = 'Отмена консультации';
    public const EMAIL_SUBJECT_REMINDER = 'Скоро консультация';
    public const EMAIL_SUBJECT_REFUSED = 'Заявка отклонена';
    public const EMAIL_SUBJECT_ACCEPTED = 'Заявка одобрена';
    public const EMAIL_SUBJECT_TEST_CHANGES = 'Тест изменился';
    public const EMAIL_SUBJECT_TEST_PASSED = 'Тест пройден';
    public const EMAIL_SUBJECT_BAN = 'Блокировка аккаунта';
    public const EMAIL_SUBJECT_UNBAN = 'Разблокировка аккаунта';

    public const ROLE_USER = 'user';
    public const ROLE_PSYCHOLOGIST = 'psychologist';
    public const ROLE_ADMIN = 'admin';
    public const ROLE_BLOCKED_PSYCHOLOGIST = 'blocked_psychologist';
    public const ROLE_SHADOW_PSYCHOLOGIST = 'shadow_psychologist';
    public const ROLE_SHADOW_USER = 'shadow_user';


}
