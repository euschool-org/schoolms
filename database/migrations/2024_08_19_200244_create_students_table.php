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
            $table->string('name',191);
            $table->string('private_number',45)->nullable();
            $table->integer('grade')->nullable();
            $table->string('group',45)->nullable();
            $table->string('sector',45)->nullable();
            $table->string('parent_name',191)->nullable();
            $table->string('parent_mail',191)->nullable();
            $table->string('parent_number', 45)->nullable();
            $table->boolean('email_notifications')->nullable();
            $table->boolean('mobile_notifications')->nullable();
            $table->text('additional_information')->nullable();
            $table->date('contract_start_date')->nullable();
            $table->date('contract_end_date')->nullable();
            $table->float('monthly_payment')->nullable();
            $table->float('yearly_payment')->nullable();
            $table->unsignedBigInteger('currency_id')->default(1);
            $table->string('parent_account',45)->nullable();
            $table->string('income_account',45)->nullable();
            $table->integer('payment_quantity')->nullable();
            $table->float('custom_discount')->nullable();
            $table->float('balance')->nullable();
            $table->timestamps();

            $table->foreign('currency_id')->references('id')->on('currencies');
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
