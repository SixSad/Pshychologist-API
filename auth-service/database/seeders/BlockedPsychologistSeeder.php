<?php

namespace Database\Seeders;

use App\Helpers\UserSeederRequest;
use App\Models\User;
use Faker\Generator;
use Illuminate\Container\Container;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlockedPsychologistSeeder extends Seeder
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

        $blockedPsychologistScheme = [
            'id' => Str::uuid(),
            'email' => 'blocked_psychologist@gmail.com',
            'password' => 'blocked_psychologist',
            'status' => 'confirmed'
        ];

        $blockedPsychologists = User::factory(1)->create(['status' => 'confirmed']);
        if (!User::query()->where('email', $blockedPsychologistScheme['email'])->first()) {
            $blockedPsychologists[] = User::query()->create($blockedPsychologistScheme);
        }

        foreach ($blockedPsychologists as $blockedPsychologist) {
            $gender = array_random(["male", "female"]);
            UserSeederRequest::send('core', 'User', 'seederCreate', [
                'attributes' => [
                    'id' => $blockedPsychologist->id,
                    'email' => $blockedPsychologist['email'],
                    'first_name' => $this->faker->firstName($gender),
                    'last_name' => $this->faker->lastName,
                    'patronymic' => $this->faker->middleName($gender),
                    'birthdate' => $this->faker->date,
                    'sex' => 'male',
                    'phone_number' => "+" . "7" . $this->faker->numerify('##########'),
                    'role' => 'blocked_psychologist'
                ]
            ]);

            $blockedPsychologist->roles()->attach('blocked_psychologist');
        }
    }
}
