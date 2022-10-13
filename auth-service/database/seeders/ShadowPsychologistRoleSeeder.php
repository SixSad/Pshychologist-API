<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class ShadowPsychologistRoleSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $shadowId = 'shadow_psychologist';
        $shadowRoleAttributes = [
            'id' => $shadowId,
            'name' => 'ShadowPsychologist',
            'is_default' => false
        ];
        if (!Role::query()->find($shadowId)) {
            Role::query()->create($shadowRoleAttributes);
        }
    }
}
