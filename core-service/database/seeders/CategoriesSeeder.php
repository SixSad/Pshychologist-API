<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Category::query()->whereBetween('id', [1, 1000])->first()) {
            return;
        }

        $dispatcher = Category::getEventDispatcher();
        Category::unsetEventDispatcher();

        Category::query()->insert([
            ['name' => 'Базовые категории', 'category_id' => NULL]
        ]);

        $test = Category::query()->first();

        $parentId = collect([1, 2, 3, 7])->map(function ($item) use ($test) {
            return $item + $test->getAttribute('id');
        });

        Category::query()->insert([
            ['name' => 'Ценностные предрасположенности', 'category_id' => NULL],
            ['name' => 'Коммуникативные ожидания', 'category_id' => NULL],
            ['name' => 'Позиция психолога по отношению к клиенту', 'category_id' => NULL],
            # Ценностные предрасположенности
            ['name' => 'Гендерные и семейные вопросы', 'category_id' => $parentId[0]],
            ['name' => 'ЛГБТ', 'category_id' => $parentId[0]],
            ['name' => 'Репродуктивные вопросы и родительство', 'category_id' => $parentId[0]],
            ['name' => 'Мировоззренческие установки', 'category_id' => $parentId[0]],
            # Мировоззренческие установки
            ['name' => 'Склонность к непознаваемому', 'category_id' => $parentId[3]],
            ['name' => 'Отношение к магическим и эзотерическим практикам', 'category_id' => $parentId[3]],
            ['name' => 'Доверие к научному знанию', 'category_id' => $parentId[3]],
            # Коммуникативные ожидания
            ['name' => 'Допустимость юмора', 'category_id' => $parentId[1]],
            ['name' => 'Склонность к ментальным абстракциям', 'category_id' => $parentId[1]],
            ['name' => 'Склонность к метафорическому языку', 'category_id' => $parentId[1]],
            ['name' => 'Прямолинейность', 'category_id' => $parentId[1]],
            ['name' => 'Дипломатичность', 'category_id' => $parentId[1]],
            # Позиция психолога по отношению к клиенту
            ['name' => 'Экспертная позиция', 'category_id' => $parentId[2]],
            ['name' => 'Авторитетная позиция', 'category_id' => $parentId[2]],
            ['name' => 'Позиция равного', 'category_id' => $parentId[2]],
        ]);

        Category::setEventDispatcher($dispatcher);
    }
}
