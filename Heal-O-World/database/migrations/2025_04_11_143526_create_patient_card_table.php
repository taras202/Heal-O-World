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
            $table->date('visit_date');
            $table->string('diagnosis');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patient_card');
    }
};
