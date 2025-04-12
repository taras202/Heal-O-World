<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained()->onDelete('cascade');
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->decimal('transaction_amount', 10, 2); 
            $table->string('status');
            $table->timestamp('payment_date');
            $table->foreignId('appointment_id')->nullable()->constrained()->onDelete('set null'); 
            $table->text('notes')->nullable();
            $table->foreignId('transaction_id')->nullable()->constrained()->onDelete('set null'); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
