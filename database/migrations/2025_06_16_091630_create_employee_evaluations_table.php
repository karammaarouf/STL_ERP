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
        //جدول التقييمات للموظفين
        Schema::create('employee_evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->foreignId('evaluator_by')->constrained('users')->onDelete('cascade');
            $table->date('evaluation_date');
            $table->decimal('score', 5, 2)->comment('الدرجة,من 0 إلى 100');
            $table->text('summary')->nullable()->comment('ملخص');
            $table->text('recommendation')->nullable()->comment('الإرشادات');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_evaluations');
    }
};
