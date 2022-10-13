<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AuthenticatePermissionSeeder::class);
        $this->call([
            UserRoleSeeder::class,
            AdminRoleSeeder::class,
            PsychologistRoleSeeder::class,
            ShadowPsychologistRoleSeeder::class,
            ShadowUserRoleSeeder::class,
            BlockedPsychologistRoleSeeder::class
        ]);
        $this->call([
            AdminSeeder::class,
            PsychologistSeeder::class,
            UserSeeder::class,
            ShadowUserSeeder::class,
            ShadowPsychologistSeeder::class,
            BlockedPsychologistSeeder::class
        ]);
    }
}
