<?php

/** @noinspection PhpMissingFieldTypeInspection */

namespace App\Providers;

use App\Events\DeletedEmailCodeEvent;
use App\Events\DeletingEmailCodeEvent;
use App\Events\SavedUserEvent;
use App\Events\SavingUserEvent;
use App\Events\SendEmailEvent;
use App\Events\SendPasswordEvent;
use App\Listeners\CheckUserStatusListener;
use App\Listeners\DeletedEmailCodeUpdateUserListener;
use App\Listeners\DeletingEmailcheckCodeListener;
use App\Listeners\CreateEmailCodeListener;
use App\Listeners\SavedUserSetRoleListener;
use App\Listeners\SavingUserOffsetModelListener;
use App\Listeners\SavingUserSetUUIDListener;
use App\Listeners\ValidateRequestListener;
use App\Listeners\SendEmailUpdateEmailCodeListener;
use App\Listeners\SendEmailMessageListener;
use Egal\Core\Events\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        SendEmailEvent::class => [
            CheckUserStatusListener::class,
            SendEmailUpdateEmailCodeListener::class,
            SendEmailMessageListener::class
        ],
        SendPasswordEvent::class => [
            CheckUserStatusListener::class,
            CreateEmailCodeListener::class,
            SendEmailMessageListener::class,
        ],
        SavingUserEvent::class => [
            SavingUserSetUUIDListener::class,
            ValidateRequestListener::class,
            SavingUserOffsetModelListener::class,
        ],
        SavedUserEvent::class => [
            SavedUserSetRoleListener::class,
            CreateEmailCodeListener::class,
            SendEmailMessageListener::class,
        ],
        DeletingEmailCodeEvent::class => [
            DeletingEmailcheckCodeListener::class,
        ],
        DeletedEmailCodeEvent::class => [
            DeletedEmailCodeUpdateUserListener::class
        ],
    ];
}
