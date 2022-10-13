<?php

namespace App\Console;

use App\Console\Commands\DebugCommand;
use App\Console\Commands\DebugModelMakeCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Console\Scheduling\ScheduleWorkCommand;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        DebugCommand::class,
        DebugModelMakeCommand::class,
        ScheduleWorkCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            DB::table('consultations')
                ->where('date', '<', Carbon::now())
                ->where('status', '=', 'booked')
                ->update(['status' => 'canceled']);
        })->hourly();
    }
}
