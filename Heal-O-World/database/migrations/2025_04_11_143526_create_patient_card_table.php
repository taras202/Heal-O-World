<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('patient_card', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('my_office_patients')->onDelete('cascade');
            $table->text('notes')->nullable();
            $table->float('height')->nullable(); 
            $table->float('weight')->nullable(); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::dropIfExists('patient_list_diagnoses');
        Schema::dropIfExists('patient_list_of_diseases');
        Schema::dropIfExists('patient_list_chronic_diseases');
        Schema::dropIfExists('patient_list_allergic_reactions');
    
        Schema::dropIfExists('patient_card');
    
        Schema::enableForeignKeyConstraints();        
    }
};
