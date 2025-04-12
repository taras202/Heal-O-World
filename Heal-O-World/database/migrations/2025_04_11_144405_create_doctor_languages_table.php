<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('doctor_languages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained('doctors');
            $table->foreignId('language_id')->constrained('languages');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('doctor_languages');
    }
};
