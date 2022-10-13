<?php

namespace Database\Seeders;

use App\Helpers\UserSeederRequest;
use App\Models\User;
use Faker\Generator;
use Illuminate\Container\Container;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ShadowPsychologistSeeder extends Seeder
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

        $shadowPsychologistScheme = [
            'id' => Str::uuid(),
            'email' => 'shadow_psychologist@gmail.com',
            'password' => 'shadow_psychologist',
            'status' => 'confirmed'
        ];

        $shadowPsychologists = User::factory(1)->create(['status' => 'confirmed']);
        if (!User::query()->where('email', $shadowPsychologistScheme['email'])->first()) {
            $shadowPsychologists[] = User::query()->create($shadowPsychologistScheme);
        }

        foreach ($shadowPsychologists as $shadowPsychologist) {
            $gender = array_random(["male", "female"]);
            UserSeederRequest::send('core', 'User', 'seederCreate', [
                'attributes' => [
                    'id' => $shadowPsychologist->id,
                    'email' => $shadowPsychologist['email'],
                    'first_name' => $this->faker->firstName($gender),
                    'last_name' => $this->faker->lastName,
                    'patronymic' => $this->faker->middleName($gender),
                    'birthdate' => $this->faker->date,
                    'sex' => 'male',
                    'phone_number' => "+" . "7" . $this->faker->numerify('##########'),
                    'role' => 'shadow_psychologist'
                ]
            ]);

            $shadowPsychologist->roles()->attach('shadow_psychologist');
        }
    }
}
