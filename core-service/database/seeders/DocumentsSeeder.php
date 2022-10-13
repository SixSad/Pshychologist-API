<?php

namespace Database\Seeders;

use App\Models\Document;
use App\Models\PsychologistData;
use App\Models\User;
use Illuminate\Database\Seeder;

class DocumentsSeeder extends Seeder
{
    public function run()
    {
        Document::unsetEventDispatcher();

        $psychologists = PsychologistData::query()->get();

        $psychologists->each(function ($item) {
            $verified = !(User::query()->find($item->id)->role === "shadow_psychologist");

            if (!Document::query()->where(["psychologist_data_id" => $item->getAttribute('id'), "type" => "passport"])->exists()) {
                Document::factory()->create(["psychologist_data_id" => $item->getAttribute('id'), "type" => "passport", "description" => NULL, "verified" => $verified]);
            }
            if (!Document::query()->where(["psychologist_data_id" => $item->getAttribute('id'), "type" => "diploma"])->exists()) {
                Document::factory(random_int(1, 3))->create(["psychologist_data_id" => $item->getAttribute('id'), "type" => "diploma", "verified" => $verified]);
            }
            if (!Document::query()->where(["psychologist_data_id" => $item->getAttribute('id'), "type" => "other"])->exists()) {
                Document::factory(random_int(1, 10))->create(["psychologist_data_id" => $item->getAttribute('id'), "type" => "other", "description" => NULL, "verified" => $verified]);
            }
        });
    }
}
