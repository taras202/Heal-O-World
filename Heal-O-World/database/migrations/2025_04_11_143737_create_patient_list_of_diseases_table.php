<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('patient_list_of_diseases', function (Blueprint $table) {
            $table->foreignId('patient_id')->constrained('my_office_patients')->onDelete('cascade');
            $table->foreignId('list_of_diseases_id')->constrained('list_of_diseases')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patient_list_of_diseases');
    }
};
