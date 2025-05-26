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
        
            $table->foreignId('payment_id')->constrained('payments')->onDelete('cascade');
        
            $table->foreignId('doctor_id')->constrained('my_office_doctors')->onDelete('cascade');
            $table->foreignId('patient_id')->constrained('my_office_patients')->onDelete('cascade');
        
            $table->decimal('amount', 10, 2);
        
            $table->enum('transaction_type', ['hold', 'release', 'refund'])->default('hold');
        
            $table->enum('status', ['pending', 'success', 'failed'])->default('pending');
        
            $table->text('description')->nullable();
        
            $table->timestamp('processed_at')->nullable();
        
            $table->timestamps();
        });
        
    }
    
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
    
};
