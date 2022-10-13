<?php

namespace Database\Seeders;

use App\Helpers\Consts;
use App\Helpers\UserSeederRequest;
use Faker\Generator;
use Illuminate\Container\Container;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
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

        $adminScheme = [
            'id' => Str::uuid(),
            'email' => 'admin@adm.com',
            'password' => 'admin',
            'status' => Consts::STATUS_CONFIRM
        ];

        if (User::query()->where('email', $adminScheme['email'])->first()) {
            return;
        }

        $admin = User::query()->create($adminScheme);

        $admin->roles()->attach('admin');

        $gender = array_random(["male", "female"]);

        UserSeederRequest::send(
            'core',
            'User',
            'seederCreate',
            [
                'attributes' => [
                    'id' => $admin->id,
                    "email" => $admin->email,
                    'first_name' => $this->faker->firstName($gender),
                    'last_name' => $this->faker->lastName,
                    'patronymic' => $this->faker->middleName($gender),
                    'birthdate' => $this->faker->date,
                    'sex' => $gender,
                    'phone_number' => "+" . "7" . $this->faker->numerify('##########'),
                    'role' => 'admin'
                ]
            ]
        );
    }
}
