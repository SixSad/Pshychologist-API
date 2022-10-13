<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class GetTimetableFunctionMigrations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("
                    CREATE OR REPLACE FUNCTION get_timetable(psychologist uuid)
                            RETURNS TABLE(schedule_id bigint,psychologist_id uuid,week_day varchar,schedule_time time,time_id bigint)
                            AS $$
                        SELECT s.id as schedule_id,s.psychologist_id, week_day, time as schedule_time, times.id as time_id
                            FROM schedules as s
                            left join times on s.id = times.schedule_id
                            WHERE psychologist_id = psychologist
                        $$ LANGUAGE SQL
        ");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP FUNCTION get_timetable');
    }
}

