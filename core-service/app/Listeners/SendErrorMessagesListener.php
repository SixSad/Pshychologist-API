<?php

namespace App\Listeners;

use App\Exceptions\NotNullVerificatedException;
use App\Exceptions\VerificatedRequiredDocumentsException;
use App\Jobs\DeclinePsychologistSender;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Sixsad\Helpers\AbstractEvent;
use Sixsad\Helpers\AbstractListener;
use Sixsad\Helpers\SessionAttributes;

class SendErrorMessagesListener extends AbstractListener
{

    public function handle(AbstractEvent $event): void
    {
        $model = $event->getModel();
        $psychologist = User::query()->find($model->getAttribute('id'));
        $attributes = SessionAttributes::getAttributes();

        if ($psychologist->getAttribute('role') !== 'shadow_psychologist'
            && $psychologist->getAttribute('role') !== 'psychologist') {
            throw new Exception('User must be a psychologist or shadow_psychologist', 400);
        }

        $documents = $model->documents;

        if ($documents->whereStrict('verified', null)->count()) {
            throw new NotNullVerificatedException();
        }

        $declineDocument = $documents->whereStrict('verified', false)->whereIn('type', ['diploma', 'passport'])->count();

        $messages = new Collection();

        if (!empty($attributes['message'])) {
            $messages->put('general', "<p>" . "<b>Общий комментарий</b> - " . $attributes['message'] . "</p>");
        } else if (!$declineDocument) {
            throw new VerificatedRequiredDocumentsException();
        }

        $documents->each(function ($item) use ($messages) {
            if ($item['verified'] === true) {
                return $item;
            }

            switch ($item['type']) {
                case "passport":
                    $messages->push("<p>" . "<b>Паспорт</b> - " . $item['massage'] . "</p>");
                    break;
                case "diploma":
                    $messages->push("<p>" . "<b>Диплом</b> - " . $item['massage'] . "</p>");
                    break;
                case "other":
                    $messages->push("<p>" . "<b>Другие документы</b> - " . $item['massage'] . "</p>");
                    break;
                default:
                    break;
            }

            return $item;
        });

        dispatch(new DeclinePsychologistSender($messages->toArray(), $psychologist));
    }

}
