<?php

namespace App\Listeners;

use App\Helpers\ArrayHelper;
use App\Helpers\SessionHelper;
use Egal\Core\Exceptions\NoAccessActionCallException;
use Sixsad\Helpers\AbstractEvent;
use Sixsad\Helpers\AbstractListener;
use Sixsad\Helpers\MicroserviceValidator;

class UserChangeDataListener extends AbstractListener
{

    public function handle(AbstractEvent $event): void
    {

        $model = $event->getModel();

        if ($model->getAttribute('id') !== SessionHelper::getUUID()) {
            throw new NoAccessActionCallException();
        }

        MicroserviceValidator::validate($model->getDirty(), [
            "first_name" => 'filled|string|bail|max:255|min:2|cyrillic',
            "last_name" => 'filled|string|bail|max:255|min:2|cyrillic',
            "patronymic" => 'filled|string|bail|max:255|min:2|cyrillic',
            "birthdate" => 'filled|bail|date_format:Y-m-d|date_eighteen|maximum_age',
            "sex" => 'filled|string|enum:male,female,none',
            "phone_number" => "filled|string|phone_number|unique:users,phone_number",
        ]);

        if (SessionHelper::getRole() === 'psychologist') {
            ArrayHelper::arrayFilter($model->getDirty(), ['first_name', 'last_name', 'patronymic', 'sex', 'phone_number']);
        }

        ArrayHelper::arrayFilter($model->getDirty(), ['first_name', 'last_name', 'patronymic', 'birthdate', 'sex', 'phone_number']);
    }

}
