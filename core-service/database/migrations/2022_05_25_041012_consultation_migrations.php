<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ConsultationMigrations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('psychologist_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->enum('week_day', ['0', '1', '2', '3', '4', '5', '6']);
            $table->date('expiration_date')->nullable();
            $table->timestamps();
        });

        Schema::create('times', function (Blueprint $table) {
            $table->id();
            $table->foreignId('schedule_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->time('time');
            $table->timestamps();
        });

        Schema::create('consultations', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date');
            $table->foreignUuid('client_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignUuid('psychologist_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->enum('status', ['booked', 'perform', 'canceled']);
            $table->timestamps();
        });

        Schema::create('consultation_rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consultation_id')->constrained('consultations')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('room_name')->unique();
            $table->string('record_link')->nullable();
            $table->dateTime('start_time');
            $table->dateTime('end_time')->nullable();
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
        Schema::dropIfExists('schedules');
        Schema::dropIfExists('times');
        Schema::dropIfExists('consultations');
        Schema::dropIfExists('consultation_rooms');
    }
}
