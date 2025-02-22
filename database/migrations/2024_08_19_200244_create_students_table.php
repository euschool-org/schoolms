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
            $table->integer('current_grade')->nullable();
            $table->string('group',45)->nullable();
            $table->string('sector',45)->nullable();
            $table->string('first_parent_name',191)->nullable();
            $table->string('first_parent_mail',191)->nullable();
            $table->string('first_parent_number', 45)->nullable();
            $table->string('second_parent_name',191)->nullable();
            $table->string('second_parent_mail',191)->nullable();
            $table->string('second_parent_number', 45)->nullable();
            $table->boolean('email_notifications')->nullable();
            $table->text('additional_information')->nullable();
            $table->date('contract_start_date')->nullable();
            $table->date('contract_end_date')->nullable();
            $table->unsignedBigInteger('currency_id')->default(1);
            $table->string('parent_account',45)->nullable();
            $table->string('income_account',45)->nullable();
            $table->boolean('new_student_discount')->nullable();
            $table->decimal('last_year_balance')->nullable();
            $table->integer('balance_change_year')->nullable();
            $table->string('payment_code',45)->unique();
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
