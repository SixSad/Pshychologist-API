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
        $this->call([
            CategoriesSeeder::class,
            WorkCategorySeeder::class,
            QuestionsSeeder::class,
            AnswersSeeder::class,
            PsychologistDataSeeder::class,
            UserResultSeeder::class,
            QuestionAnswerSeeder::class,
            ScheduleSeeder::class,
            DocumentsSeeder::class,
        ]);
    }
}
