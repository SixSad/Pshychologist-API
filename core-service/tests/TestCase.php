<?php

use Egal\Auth\Tokens\UserServiceToken;
use Egal\Core\Messages\ActionMessage;
use Egal\Core\Messages\MessageType;
use Egal\Core\Session\Session;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Application;
use Laravel\Lumen\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected $baseUrl = 'http://web-service:8080';

    /**
     * Creates the application.
     *
     * @return Application
     * @noinspection PhpMissingReturnTypeInspection
     */
    public function createApplication()
    {
        return require __DIR__ . '/../bootstrap/app.php';
    }

    public static function setJWT(Model $user)
    {
        $ust = new UserServiceToken();
        $ust->setSigningKey('w8D3A9XNhR0ckQlGo*%LWFfPzuHEKxj4');
        $ust->setAuthInformation([
            'id' => $user->getAttribute('id'),
            'email' => $user->getAttribute('email'),
            'status' => 'confirmed',
            'auth_identification' => $user->getAttribute('id'),
            'roles' => [$user->getAttribute('role')],
            'permissions' => ["authenticate"],
            'timezone' => 0
        ]);

        return $ust;
    }

    public static function setSession(string $service, string $model, string $action, array $attributes, UserServiceToken $ust = null)
    {
        Session::setActionMessage(ActionMessage::fromArray([
            'type' => MessageType::ACTION,
            'service_name' => $service,
            'model_name' => $model,
            'action_name' => $action,
            'parameters' => $attributes,
            'uuid' => 'uuid'
        ]));

        if ($ust) {
            Session::setUserServiceToken($ust);
        }
    }

}
