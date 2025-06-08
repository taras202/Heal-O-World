<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaticContentsTable extends Migration
{
    public function up()
    {
        Schema::create('static_contents', function (Blueprint $table) {
            $table->id();
            $table->string('mission_title')->nullable();
            $table->text('mission_text')->nullable();
            $table->string('why_us_title')->nullable();
            $table->text('why_us_list')->nullable();
            $table->string('reviews_title')->nullable();
            $table->text('reviews_text')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('static_contents');
    }
}
