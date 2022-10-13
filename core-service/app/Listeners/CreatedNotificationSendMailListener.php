<?php

namespace App\Listeners;

use App\Jobs\TestPassedSender;
use Carbon\Carbon;
use Illuminate\Support\Facades\Queue;
use Sixsad\Helpers\AbstractEvent;
use Sixsad\Helpers\AbstractListener;

class CreatedNotificationSendMailListener extends AbstractListener
{

    public function handle(AbstractEvent $event): void
    {
        parent::handle($event);
        $delay = Carbon::today()->addDays(7);
        Queue::later($delay, new TestPassedSender($event->getModel()));
    }

}
