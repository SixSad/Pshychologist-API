<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class ShadowUserRoleSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $shadowId = 'shadow_user';
        $shadowRoleAttributes = [
            'id' => $shadowId,
            'name' => 'ShadowUser',
            'is_default' => false
        ];
        if (!Role::query()->find($shadowId)) {
            Role::query()->create($shadowRoleAttributes);
        }
    }
}
