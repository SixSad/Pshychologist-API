<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PsyhologistDataMigrations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('psychologist_data', function (Blueprint $table) {
            $table->foreignUuid('id')->primary()->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->binary('avatar');
            $table->integer('experience');
            $table->text('description');
            $table->string('video_link');
            $table->timestamps();
        });

        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('psychologist_data_id')->constrained('psychologist_data')->cascadeOnDelete()->cascadeOnUpdate();
            $table->binary('photo');
            $table->text('description')->nullable();
            $table->enum('type', ['passport', 'diploma', 'other']);
            $table->boolean('verified')->nullable();
            $table->text('message')->nullable();
            $table->timestamps();
        });

            Schema::create('work_categories', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('type', ['method', 'error']);
            $table->timestamps();
        });

        Schema::create('work_category_psychologists', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('psychologist_data_id')->constrained('psychologist_data')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('work_category_id')->constrained('work_categories')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('psychologist_data');
        Schema::dropIfExists('documents');
        Schema::dropIfExists('work_categories');
        Schema::dropIfExists('work_category_psychologists');
    }
}
