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
        // جدول عقد الموظف
        Schema::create('employee_contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->string('contract_number', 50)->unique();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->enum('contract_type', ['full_time', 'part_time', 'temporary', 'intern'])->comment('نوع العقد, كامل وقت, جزئي, مؤقت, متدرب');
            $table->decimal('basic_salary', 15, 2)->comment('الراتب الأساسي');
            $table->foreignId('salary_currency_id')->nullable()->constrained('currencies')->onDelete('set null');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_contracts');
    }
};
