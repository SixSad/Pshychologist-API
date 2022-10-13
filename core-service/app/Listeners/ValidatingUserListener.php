<?php

namespace App\Listeners;

use App\Helpers\Consts;
use App\Helpers\SessionHelper;
use Egal\Core\Communication\Request;
use Egal\Core\Session\Session;
use Egal\Model\Exceptions\ObjectNotFoundException;
use Sixsad\Helpers\AbstractEvent;
use Sixsad\Helpers\AbstractListener;

class ValidatingUserListener extends AbstractListener
{

    public function handle(AbstractEvent $event): void
    {
        if (Session::getActionMessage()->getActionName() === 'create') {

            $user = $event->getModel();

            $user->setAttribute('id', SessionHelper::getUUID());
            SessionHelper::getRole() === 'shadow_user'
                ? $user->setAttribute('role', 'user')
                : $user->setAttribute('role', 'shadow_psychologist');

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
        }

    }

}
