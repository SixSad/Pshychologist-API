<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class SqlHelper
{
    public static function getPsyResult(array $question_ids): array
    {
        return DB::select('select 
        "users"."id", 
        "question_answers"."question_id", 
        "question_answers"."answer_option" 
      from 
        "users" 
        inner join(
          select 
            * 
          from 
            "user_results" 
          where 
            "user_results"."id" in (
              select 
                "id" 
              from 
                (
                  select 
                    MAX("user_results"."id") as "id", 
                    "user_results"."user_id" 
                  from 
                    "user_results" 
                  group by 
                    "user_results"."user_id"
                ) as "q"
            )
        ) as "ur" on "users"."id" = "ur"."user_id" 
        inner join "question_answers" on "ur"."id" = "question_answers"."user_result_id" 
      where  
      "question_answers"."question_id" in (' . implode(',', $question_ids)  . ') and
        "role" =  \'psychologist\' and exists ( select * from "user_results" where "users"."id" = "user_results"."user_id" ) and exists ( select * from "schedules" where "users"."id" = "schedules"."psychologist_id" ) and exists ( select * from "psychologist_data" where "users"."id" = "psychologist_data"."id" ) and exists ( select * from "user_results" inner join ( select MAX("user_results"."id") as "id_aggregate", "user_results"."user_id" from "user_results" group by "user_results"."user_id" ) as "latestOfMany" on "latestOfMany"."id_aggregate" = "user_results"."id" and "latestOfMany"."user_id" = "user_results"."user_id" where "users"."id" = "user_results"."user_id" and ( select count(*) from "question_answers" where "user_results"."id" = "question_answers"."user_result_id" ) = ( select count(*) from "questions" where "type" = \'many\' or ( "type" = \'one\' and exists ( select * from "answer_options" where "questions"."id" = "answer_options"."question_id" ) ) ) ) and exists ( select * from "schedules" where "users"."id" = "schedules"."psychologist_id" and exists ( select * from "times" where "schedules"."id" = "times"."schedule_id" ) )');
    }

    public static function getUserResultById(string $id): array
    {
        return DB::select('
        select
            "question_answers"."question_id", 
            "question_answers"."answer_option" 
        from 
        "users" 
        inner join(
            select 
            * 
            from 
            "user_results" 
            where 
            "user_results"."id" in (
                select 
                "id" 
                from 
                (
                    select 
                    MAX("user_results"."id") as "id", 
                    "user_results"."user_id" 
                    from 
                    "user_results" 
                    group by 
                    "user_results"."user_id"
                ) as "q"
            )
        ) as "ur" on "users"."id" = "ur"."user_id" 
        inner join "question_answers" on "ur"."id" = "question_answers"."user_result_id" 
        where 
        "users"."id" =  ?', [$id]);
    }
}
