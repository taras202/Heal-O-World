<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('educations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained('my_office_doctors')->onDelete('cascade');
            $table->string('institution');
            $table->string('degree');
            $table->year('start_year');
            $table->year('end_year')->nullable();
        
            $table->string('diploma_photo_1')->nullable();
            $table->string('diploma_photo_2')->nullable();
            $table->string('diploma_photo_3')->nullable();
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('educations');
    }
};
