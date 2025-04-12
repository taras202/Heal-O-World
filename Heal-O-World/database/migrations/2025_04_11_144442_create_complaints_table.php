<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->text('text');
            $table->foreignId('consultation_id')->constrained('consultations');
            $table->string('status');
            $table->foreignId('sender_id')->constrained('users');
            $table->string('type');
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('complaints');
    }    
};
