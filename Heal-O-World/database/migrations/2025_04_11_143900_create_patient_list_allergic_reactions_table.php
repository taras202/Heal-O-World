<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('patient_list_allergic_reactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_card_id');
            $table->unsignedBigInteger('list_allergic_reactions_id');
            $table->timestamps();

            $table->foreign('patient_card_id')
                ->references('id')->on('patient_card')
                ->onDelete('cascade');

            $table->foreign('list_allergic_reactions_id')
                ->references('id')->on('list_allergic_reactions')
                ->onDelete('cascade')
                ->name('fk_patient_list_allergic_reactions_list_allergic_reactions_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patient_list_allergic_reactions');
    }
};
