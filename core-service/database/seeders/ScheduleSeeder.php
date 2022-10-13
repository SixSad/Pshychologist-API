<?php

namespace Database\Seeders;

use App\Models\Schedule;
use App\Models\Time;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schedule::unsetEventDispatcher();
        $psychologists = User::query()->where('role', 'psychologist')->pluck('id');

        foreach ($psychologists as $psychologist) {
            Schedule::factory()->has(Time::factory()->count(random_int(1, 4))->state(new Sequence(
                ['time' => Carbon::yesterday()->addHours(random_int(0, 5))->isoFormat('HH:mm:ss')],
                ['time' => Carbon::yesterday()->addHours(random_int(6, 10))->isoFormat('HH:mm:ss')],
                ['time' => Carbon::yesterday()->addHours(random_int(11, 15))->isoFormat('HH:mm:ss')],
                ['time' => Carbon::yesterday()->addHours(random_int(16, 20))->isoFormat('HH:mm:ss')],
                ['time' => Carbon::yesterday()->addHours(random_int(21, 23))->isoFormat('HH:mm:ss')]
            )))->state(new Sequence(
                ['week_day' => '0'],
                ['week_day' => '1'],
                ['week_day' => '2'],
                ['week_day' => '3'],
                ['week_day' => '4'],
                ['week_day' => '5'],
                ['week_day' => '6']
            ))->count(7)->create([
                'psychologist_id' => $psychologist,
            ]);
        }
    }
}
