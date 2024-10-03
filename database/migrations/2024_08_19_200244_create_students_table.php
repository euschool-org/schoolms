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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('firstname',45);
            $table->string('lastname',45);
            $table->string('private_number',45)->nullable();
            $table->string('grade')->nullable();
            $table->string('group',1)->nullable();
            $table->string('sector',45)->nullable();
            $table->integer('pupil_status')->nullable();
            $table->string('parent_mail',191)->nullable();
            $table->string('parent_number', 45)->nullable();
            $table->text('additional_information')->nullable();
            $table->integer('contract_end_date')->nullable();
            $table->float('monthly_payment')->nullable();
            $table->float('yearly_payment')->nullable();
            $table->string('currency', 3)->default('EUR');
            $table->string('parent_account',45)->nullable();
            $table->string('income_account',45)->nullable();
            $table->integer('payment_quantity')->nullable();
            $table->float('custom_discount')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
