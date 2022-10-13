<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class BlockedPsychologistRoleSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleId = 'blocked_psychologist';
        $roleAttributes = [
            'id' => $roleId,
            'name' => 'BlockedPsychologist',
            'is_default' => false
        ];
        if (!Role::query()->find($roleId)) {
            Role::query()->create($roleAttributes);
        }
    }
}
