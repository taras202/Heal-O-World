<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('patient_list_allergic_reactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('my_office_patients')->onDelete('cascade');
            $table->unsignedBigInteger(column: 'list_allergic_reactions_id');
            $table->foreign('list_allergic_reactions_id', 'patient_list_allergic_reactions_foreign')
                  ->references('id')->on('list_allergic_reactions')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patient_list_allergic_reactions');
    }
};
