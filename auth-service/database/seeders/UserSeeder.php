<?php

namespace Database\Seeders;

use App\Helpers\Consts;
use App\Helpers\UserSeederRequest;
use App\Models\Role;
use App\Models\User;
use Faker\Generator;
use Illuminate\Container\Container;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
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

        $userScheme = [
            'id' => Str::uuid(),
            'email' => 'user@us.com',
            'password' => 'user',
            'status' => Consts::STATUS_CONFIRM

        ];

        if (User::query()->where('email', $userScheme['email'])->first()) {
            return;
        }

        if (User::query()->where("email", "user_1@gmail.com")->first()) {
            return;
        }

        User::factory(6)->create([
            'password' => 'user',
            "status" => "confirmed"
        ])->each(function ($user, $key) {
            $user->update(["email" => "user" . '_' . ($key + 1) . "@gmail.com"]);

            $user->roles()->attach('user');
            $gender = array_random(["male", "female"]);
            UserSeederRequest::send(
                'core',
                'User',
                'seederCreate',
                [
                    'attributes' => [
                        'id' => $user->id,
                        'email' => $user['email'],
                        'first_name' => $this->faker->firstName($gender),
                        'last_name' => $this->faker->lastName,
                        'patronymic' => $this->faker->middleName($gender),
                        'birthdate' => $this->faker->date,
                        'sex' => 'male',
                        'phone_number' => "+" . "7" . $this->faker->numerify('##########'),
                        'role' => 'user'
                    ]
                ]
            );
        });
    }
}
