<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('patient_id')->nullable()->constrained('my_office_patients')->onDelete('cascade');
            
            $table->foreignId('doctor_id')->constrained('my_office_doctors')->onDelete('cascade');
            
            $table->string('google_meet_link')->nullable(); 
            $table->date('appointment_date');
            $table->string('consultation_time');
            $table->text('diagnosis')->nullable();  
            $table->text('prescription')->nullable();  
            $table->enum('status', ['pending', 'completed', 'cancelled'])->default('pending');
            $table->text('treatment')->nullable(); 
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consultations');
    }
};
