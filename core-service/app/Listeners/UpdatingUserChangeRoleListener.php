<?php

namespace App\Listeners;

use App\Helpers\ArrayHelper;
use App\Helpers\SendRequest;
use App\Jobs\PsychologistBanSender;
use App\Jobs\PsychologistUnbanSender;
use App\Models\Consultation;
use Sixsad\Helpers\AbstractEvent;
use Sixsad\Helpers\AbstractListener;
use Sixsad\Helpers\MicroserviceValidator;
use Sixsad\Helpers\SessionAttributes;

class UpdatingUserChangeRoleListener extends AbstractListener
{

    public function handle(AbstractEvent $event): void
    {

        $model = $event->getModel();
        $attributes = SessionAttributes::getAttributes();

        MicroserviceValidator::validate($attributes, [
            "id" => "bail|required|uuid|check_user_role:psychologist,blocked_psychologist,shadow_psychologist",
            "role" => "bail|required|string|in:blocked_psychologist,psychologist",
            "message" => "required_if:role,blocked_psychologist|string|min:10|max:200"
        ]);

        if ($attributes['role'] === 'psychologist') {
            ArrayHelper::arrayFilter($attributes, ['role']);
        } else {
            ArrayHelper::arrayFilter($attributes, ['role', 'message']);
        }

        if ($model->getAttribute('role') === 'psychologist') {
            (new UpdatingUserAdminApproveListener())->handle($event);
        }

        SendRequest::send('auth', 'User', 'changeUserRole', [
            "attributes" => [
                "id" => $model->getAttribute('id'),
                "role" => $model->getAttribute('role')
            ],
        ]);

        if ($model->getOriginal('role') === 'psychologist') {
            dispatch(new PsychologistBanSender($attributes['message'], $event->getModel()));
            Consultation::query()
                ->where('psychologist_id', $model->getAttribute('id'))
                ->update(['status' => 'canceled']);
        }

        if ($model->getOriginal('role') === 'blocked_psychologist') {
            dispatch(new PsychologistUnbanSender($event->getModel()));
        }
    }

}
