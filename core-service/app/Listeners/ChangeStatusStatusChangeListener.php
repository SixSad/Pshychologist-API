<?php

namespace App\Listeners;

use App\Helpers\Consts;
use App\Models\User;
use Sixsad\Helpers\AbstractEvent;
use Sixsad\Helpers\AbstractListener;
use Exception;

class ChangeStatusStatusChangeListener extends AbstractListener
{
    /**
     * @property User $user
     */
    public function handle(AbstractEvent $event): void
    {
        parent::handle($event);
        $user = $event->getModel();

        if ($user['role'] === Consts::ROLE_USER) {

            $request = new \Egal\Core\Communication\Request(
                'auth',
                'UserRole',
                'updateManyRaw',
                [
                    'attributes' => [
                        'role_id' => Consts::ROLE_USER
                    ],

                    "filter" => [
                        ["user_id", "eq", $user['id']]
                    ],

                ]
            );
            $request->call();
            $response = $request->getResponse();

            if ($response->getStatusCode() !== 200) {
                $actionErrorMessage = $response->getActionErrorMessage()->getMessage();
                $actionErrorCode = $response->getActionErrorMessage()->getCode();
                throw new Exception($actionErrorMessage, $actionErrorCode);
            }
        }

    }
}

