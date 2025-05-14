<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('my_office_patients', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->date('date_of_birth');
            $table->string('gender');
            $table->string('has_insurance');
            $table->string('country_of_residence');
            $table->string('city_of_residence');
            $table->string('time_zone')->nullable();
            $table->text('notes')->nullable();
            $table->string('contact')->nullable();
            
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('my_office_patients');
        Schema::enableForeignKeyConstraints();        
    }
};
