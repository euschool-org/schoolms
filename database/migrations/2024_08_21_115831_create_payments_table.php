<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->string('payment_id')->nullable();
            $table->dateTime('payment_date');
            $table->decimal('payment_amount');
            $table->decimal('nominal_amount');
            $table->decimal('discount', 5, 2);
            $table->decimal('currency_rate', 8, 4);
            $table->string('payer_name', 191)->nullable();
            $table->timestamps();

            $table->foreign('student_id')->references('id')->on('students')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
