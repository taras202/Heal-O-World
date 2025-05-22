<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('my_office_doctors', function (Blueprint $table) {
            $table->id(); 
            $table->foreignId('user_id')
                ->constrained() 
                ->onDelete('cascade') 
                ->unique(); 
            $table->string('first_name'); 
            $table->string('last_name'); 
            $table->text('bio')->nullable(); 
            $table->string('gender')->nullable();
            $table->string('photo')->nullable();
            $table->string('contact')->nullable(); 

            $table->foreignId('time_zone_id')->nullable()->constrained('time_zones')->onDelete('set null');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('my_office_doctors');
        Schema::enableForeignKeyConstraints();
    }    
};
