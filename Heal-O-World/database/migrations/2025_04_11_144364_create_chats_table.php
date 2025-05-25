<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('chats', function (Blueprint $table) {
            $table->id();

            $table->foreignId('doctor_id')->constrained('my_office_doctors')->onDelete('cascade');
            $table->foreignId('patient_id')->constrained('my_office_patients')->onDelete('cascade');

            $table->string('status')->default('active');
            $table->timestamps();

            $table->unique(['doctor_id', 'patient_id']); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chats');
    }
};
