<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('monthly_fees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete(); // Student association
            $table->date('month')->nullable(); // Specific month (e.g., 2024-09-01 for September 2024)
            $table->string('school_year'); // Specific month (e.g., 2024-09-01 for September 2024)
            $table->decimal('fee', 10, 2)->default(0); // Monthly fee amount
            $table->timestamps();

            $table->unique(['student_id', 'month']); // Ensure no duplicate entries for the same month and student
        });
    }

    public function down()
    {
        Schema::dropIfExists('monthly_fees');
    }
};
