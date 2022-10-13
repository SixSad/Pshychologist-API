<?php

namespace App\Models;

use App\Events\CreatedNotificationEvent;
use App\Events\SendErrorMessagesEvent;
use App\Jobs\SendToEmailJob;
use Carbon\Carbon;
use Egal\Model\Model as EgalModel;
use Illuminate\Support\Facades\DB;
use Sixsad\Helpers\MicroserviceValidator;

/**
 * @property $id {@property-type field} {@prymary-key}
 * @property $email {@property-type field} {@validation-rules required|email}
 * @property $created_at {@property-type field}
 * @property $updated_at {@property-type field}
 *
 * @action sendMailTestChange {@statuses-access logged} {@roles-access admin}
 * @action sendErrorMessages {@statuses-access logged} {@roles-access admin}
 * @action testStartNotifications {@statuses-access logged} {@permissions-access admin}
 * @action create {@statuses-access guest|logged}
 * @action delete {@statuses-access logged} {@permissions-access admin}
 */
class Notification extends EgalModel
{

    protected $dispatchesEvents = [
        'created' => CreatedNotificationEvent::class
    ];

    protected $fillable = [
        'email',
        'date'
    ];

    public static function actionSendMailTestChange(): string
    {
        dispatch(new SendToEmailJob());

        return "Message sent!";
    }

    public static function actionTestStartNotifications($attributes): string
    {
        $jobs = DB::table('jobs')->get();

        $jobs = $jobs->filter(function ($item) use ($attributes) {
            $item = collect($item);
            $json = json_decode($item['payload']);
            $deserialize = unserialize($json->data->command);
            $model = $deserialize->getJobModel();
            $email = $model->getAttribute('email') ? [$model->getAttribute('email')] : collect([$model->client->getAttribute('email'), $model->psychologist->getAttribute('email')])->toArray();

            return in_array($attributes['email'], $email);
        });

        DB::table('jobs')->whereIn('id', $jobs->pluck('id'))->update(['available_at' => Carbon::now()->addSeconds(5)->timestamp]);

        return "Notifications fired ids:{$jobs->pluck('id')}";
    }

    public static function actionSendErrorMessages(array $attributes = []): string
    {

        MicroserviceValidator::validate($attributes, [
            "psychologist_data_id" => "required|uuid|exists:psychologist_data,id",
            "message" => "filled|string",
        ]);

        $model = PsychologistData::query()->find($attributes['psychologist_data_id']);

        event(new SendErrorMessagesEvent($model));

        return "Message sent!";
    }

}
