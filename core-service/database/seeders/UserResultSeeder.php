<?php

namespace Database\Seeders;

use App\Models\PsychologistData;
use App\Models\UserResult;
use Illuminate\Database\Seeder;

class UserResultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserResult::unsetEventDispatcher();
        $psychologistsData = PsychologistData::all()->pluck('id');

        $psychologistsData->each(function ($item) {
            if (!UserResult::query()->where('user_id', $item)->exists()) {
                UserResult::factory()->create(['user_id' => $item]);
            }
        });
    }
}
