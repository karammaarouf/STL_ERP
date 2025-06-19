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
        //جدول  التحذيرات
        Schema::create('employee_warnings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->enum('warning_type', ['absence_without_notice', 'policy_violation', 'performance_issue', 'other'])->comment('نوع الشهادة, مثلا غياب بدون إشعار, تخطيط سياسة, مشكلة أداء, أخرى');
            $table->text('description');
            $table->foreignId('issued_by')->nullable()->constrained('users')->onDelete('set null');
            $table->dateTime('issued_at')->useCurrent(); 
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_warnings');
    }
};
