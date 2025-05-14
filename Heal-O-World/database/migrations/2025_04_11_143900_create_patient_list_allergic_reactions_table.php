<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('patient_list_allergic_reactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_card_id')->constrained('patient_card')->onDelete('cascade');
            $table->foreignId('list_allergic_reactions_id')->constrained('list_allergic_reactions')->onDelete('cascade');
            $table->timestamps();
        });
        
    }

    public function down(): void
    {
        Schema::dropIfExists('patient_list_allergic_reactions');
    }
};
