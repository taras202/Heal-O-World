<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('doctor_specialty', function (Blueprint $table) {

            $table->foreignId('doctor_id')
                ->constrained('my_office_doctors')
                ->onDelete('cascade'); 

            $table->foreignId('specialty_id')
                ->constrained('specialties')
                ->onDelete('cascade'); 

            $table->string('experience');
            $table->decimal('price', 8, 2);
            $table->timestamps();

            $table->primary(['doctor_id', 'specialty_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctor_specialty');
    }
};
