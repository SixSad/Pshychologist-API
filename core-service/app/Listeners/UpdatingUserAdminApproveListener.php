<?php

namespace App\Listeners;

use App\Exceptions\UpdateException;
use App\Jobs\ApprovePsychologistSender;
use App\Models\Document;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Sixsad\Helpers\AbstractEvent;
use Sixsad\Helpers\AbstractListener;

class UpdatingUserAdminApproveListener extends AbstractListener
{

    public function handle(AbstractEvent $event): void
    {
        $model = $event->getModel();
        $documents = Document::query()->where('psychologist_data_id', $model->getAttribute('id'))->where(function ($query) {
            $query->whereNull('verified')->orWhere([
                ['verified', '=', false],
                ['type', '!=', 'other']
            ]);
        });

        if ($documents->exists()) {
            throw new UpdateException('Check verified document');
        }

        if (!Schedule::query()->where('psychologist_id', $model->getAttribute('id'))->exists()) {
            Schedule::factory()->state(new Sequence(
                ['week_day' => '0'],
                ['week_day' => '1'],
                ['week_day' => '2'],
                ['week_day' => '3'],
                ['week_day' => '4'],
                ['week_day' => '5'],
                ['week_day' => '6']
            ))->count(7)->create([
                'psychologist_id' => $model->getAttribute('id'),
                'expiration_date' => Carbon::now()->addDays(7)->toDateString()
            ]);

            dispatch(new ApprovePsychologistSender($event->getModel()));
        }
    }

}
