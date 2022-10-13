<?php

namespace Database\Seeders;

use App\Models\PsychologistData;
use App\Models\User;
use App\Models\WorkCategory;
use Faker\Factory;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class PsychologistDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PsychologistData::unsetEventDispatcher();

        $psychologists = User::query()->whereIn('role', ['psychologist', 'shadow_psychologist', 'blocked_psychologist'])->get();

        $methods = WorkCategory::all();

        $psychologists->each(function ($item) use ($methods) {
            if (!PsychologistData::query()->find($item->getAttribute('id'))) {
                $data = PsychologistData::factory()->create(['id' => $item->getAttribute('id')]);
                $data->workCategories()->attach(
                    $methods->random(random_int(1, 8))->pluck('id')->toArray()
                );
            }
        });
    }
}
