<?php

use App\Models\User;
use App\Models\UserResult;
use Egal\Auth\Tokens\UserServiceToken;
use Egal\Core\Session\Session;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class UserResultTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUserResultCreate()
    {

        User::unsetEventDispatcher();
        $session = new Session;
        dump($session);

        $userData = User::factory()->create();
        $ust = new UserServiceToken();
        $ust->setSigningKey('w8D3A9XNhR0ckQlGo*%LWFfPzuHEKxj4');
        $ust->setAuthInformation([
            'auth_identification' => $userData->getAttribute('id'),
            'roles' => [$userData->getAttribute('role')],
            'permissions' => ["authenticate"],
            'timezone' => 0
        ]);
        dump($ust);
        $session->setUserServiceToken($ust);
        dump($session);
//
//        $session = Mockery::mock(\Egal\Core\Session\Session::class);
//        $session->shouldReceive('UST')->andReturn($ust);

        UserResult::actionCreate();

        $this->seeInDatabase('user_results', ['user_id', $userData->getAttribute('id')]);
    }

    public function testTrue()
    {
        $this->assertTrue(true);
    }

}
