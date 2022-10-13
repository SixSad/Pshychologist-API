<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class PsychologistRoleSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $psychologId = 'psychologist';

        $psychologRoleAttributes = [
            'id' => $psychologId,
            'name' => 'Psychologist',
            'is_default' => false
        ];

        if (!Role::query()->find($psychologId)) {
            Role::query()->create($psychologRoleAttributes);
        }
    }
}
