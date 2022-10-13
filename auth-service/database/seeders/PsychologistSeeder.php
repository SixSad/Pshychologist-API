<?php

namespace Database\Seeders;

use App\Helpers\UserSeederRequest;
use App\Models\User;
use Faker\Generator;
use Illuminate\Container\Container;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PsychologistSeeder extends Seeder
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

        $psychologistScheme = [
            'id' => Str::uuid(),
            'email' => 'psychologist@psy.com',
            'password' => 'psychologist',
            'status' => 'confirmed'
        ];

        $psychologists = User::factory(15)->create(['status' => 'confirmed']);
        if (!User::query()->where('email', $psychologistScheme['email'])->first()) {
            $psychologists[] = User::query()->create($psychologistScheme);
        }

        foreach ($psychologists as $psychologist) {
            $gender = array_random(["male", "female"]);
            UserSeederRequest::send('core', 'User', 'seederCreate', [
                'attributes' => [
                    'id' => $psychologist->id,
                    'email' => $psychologist['email'],
                    'first_name' => $this->faker->firstName($gender),
                    'last_name' => $this->faker->lastName,
                    'patronymic' => $this->faker->middleName($gender),
                    'birthdate' => $this->faker->date,
                    'sex' => 'male',
                    'phone_number' => "+" . "7" . $this->faker->numerify('##########'),
                    'role' => 'psychologist'
                ]
            ]);

            $psychologist->roles()->attach('psychologist');
        }
    }
}
