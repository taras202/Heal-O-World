<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('work_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained('my_office_doctors')->onDelete('cascade');
            $table->string('day_of_the_week');
            $table->time('hours_with');
            $table->time('hours_after');
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('work_schedules');
    }    
};
