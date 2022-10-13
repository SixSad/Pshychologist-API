<?php

namespace App\Listeners;

use App\Exceptions\EmptyPasswordException;
use App\Helpers\SessionHelper;
use App\Models\User;
use Egal\Core\Communication\Request;
use Egal\Model\Exceptions\ObjectNotFoundException;
use Egal\Model\Exceptions\ValidateException;
use Sixsad\Helpers\AbstractEvent;
use Sixsad\Helpers\AbstractListener;
use Sixsad\Helpers\MicroserviceValidator;

class CreateUserRegisterListener extends AbstractListener
{
    /**
     * @param AbstractEvent $event
     * @throws EmptyPasswordException
     * @throws ValidateException
     * @property User $user
     */
    public function handle(AbstractEvent $event): void
    {
        $user = $event->getModel();
        $user->setAttribute('id', SessionHelper::getUUID());
        $user->setAttribute('role', SessionHelper::getRole());

        $request = new Request('auth', 'User', 'getItems', [
            "filter" => [
                ['id', 'eq', $user->getAttribute('id')]
            ]
        ]);
        $request->call();

        $response = collect($request->getResponse()->getResultData()['items']);

        if (empty($response)) {
            throw new ObjectNotFoundException();
        }

        $user->setAttribute('email', $response->pluck('email')->first());

        MicroserviceValidator::validate($user->getAttributes(), [
            'id' => 'required|uuid|unique:users',
            "email" => 'required|unique:users,email|email',
            "first_name" => 'required|string|max:255|cyrillic',
            "last_name" => 'required|string|max:255|cyrillic',
            "patronymic" => 'string|max:255|cyrillic',
            "birthdate" => 'bail|required|date_format:Y-m-d|date_eighteen|maximum_age',
            "sex" => 'required|string|enum:male,female,none',
            "phone_number" => "required|string|phone_number|unique:users",
        ]);
    }
}
