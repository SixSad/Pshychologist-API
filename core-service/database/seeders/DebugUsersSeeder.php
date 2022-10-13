<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DebugUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dispatcher = User::getEventDispatcher();
        User::unsetEventDispatcher();
        User::factory()->count(10)->create();
        User::setEventDispatcher($dispatcher);
    }
}
