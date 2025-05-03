<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlaceOfWorksTable extends Migration
{
    public function up()
    {
        Schema::create('place_of_works', function (Blueprint $table) {
            $table->id();
            $table->string('workplace');
            $table->string('position');
            $table->string('country_of_residence');
            $table->string('city_of_residence');
            $table->timestamps();

            $table->foreignId('doctor_id')->constrained('my_office_doctors')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('place_of_works');
    }
}
