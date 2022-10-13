<?php

namespace Database\Seeders;

use App\Helpers\Consts;
use App\Helpers\UserSeederRequest;
use App\Models\User;
use Faker\Generator;
use Illuminate\Container\Container;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ShadowUserSeeder extends Seeder
{

    protected $faker;

    public function __construct()
    {
        $this->faker = Container::getInstance()->make(Generator::class);
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        User::unsetEventDispatcher();

        $shadowUserScheme = [
            'id' => Str::uuid(),
            'email' => 'shadow_user@gmail.com',
            'password' => 'shadow_user',
            'status' => Consts::STATUS_CONFIRM
        ];

        $shadowUsers = User::factory(1)->create(['status' => Consts::STATUS_CONFIRM]);
        if (!User::query()->where('email', $shadowUserScheme['email'])->first()) {
            $shadowUsers[] = User::query()->create($shadowUserScheme);
        }

        foreach ($shadowUsers as $shadowUser) {
            $gender = array_random(["male", "female"]);
            UserSeederRequest::send('core', 'User', 'seederCreate', [
                'attributes' => [
                    'id' => $shadowUser->id,
                    'email' => $shadowUser['email'],
                    'first_name' => $this->faker->firstName($gender),
                    'last_name' => $this->faker->lastName,
                    'patronymic' => $this->faker->middleName($gender),
                    'birthdate' => $this->faker->date,
                    'sex' => 'male',
                    'phone_number' => "+" . "7" . $this->faker->numerify('##########'),
                    'role' => 'shadow_user'
                ]
            ]);

            $shadowUser->roles()->attach('shadow_user');
        }
        $exceptedUserScheme = [
            'id' => Str::uuid(),
            'email' => 'excepted_user@gmail.com',
            'password' => 'excepted',
            'status' => Consts::STATUS_EXPECT
        ];

        if (!User::query()->where('email', $exceptedUserScheme['email'])->first()) {
            $user =  User::query()->create($exceptedUserScheme);
            $user->roles()->attach('shadow_user');
        }
    }
}
