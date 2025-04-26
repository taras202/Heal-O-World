<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('my_office_doctors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
            ->constrained()
            ->onDelete('cascade')
            ->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->text('bio')->nullable();
            $table->string('gender')->nullable();
            $table->string('photo')->nullable();
            $table->string('country_of_residence');
            $table->string('city_of_residence');
            $table->string('contact')->nullable();
            $table->string('workplace')->nullable();
            $table->string('position')->nullable();
            $table->integer('time_zone');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('my_office_doctors');
    }
};
