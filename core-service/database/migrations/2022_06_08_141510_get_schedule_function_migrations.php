<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class GetScheduleFunctionMigrations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("
                    CREATE OR REPLACE FUNCTION get_schedule(start_date timestamp,end_date timestamp, psychologist uuid)
                            RETURNS TABLE(psychologist_id uuid,week_day varchar,consultation_time time)
                            AS $$
                        SELECT s.psychologist_id, week_day, time as consultation_time
                            FROM schedules as s
                            left join times on s.id = times.schedule_id
                            WHERE psychologist_id = psychologist
                            AND expiration_date >= CURRENT_DATE
                            AND week_day||' '||EXTRACT(hour from time) NOT IN (
                                                                    SELECT EXTRACT(DOW FROM date)::VARCHAR||' '||EXTRACT(hour from date) as date_time
                                                                        FROM consultations
                                                                        WHERE psychologist_id = psychologist AND status = 'booked')
                    $$ LANGUAGE SQL;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP FUNCTION get_schedule');
    }
}
