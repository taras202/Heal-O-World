<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_id')->constrained('payments');
            $table->foreignId('doctor_id')->constrained('my_office_doctors')->onDelete('cascade');
            $table->foreignId('patient_id')->constrained('my_office_patients')->onDelete('cascade');
            $table->string('amount');
            $table->string('transaction_type');
            $table->string('status');
            $table->text('description');
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
    
};
