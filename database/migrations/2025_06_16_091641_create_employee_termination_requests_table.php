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
        // جدول طلبات إلغاء خدمة الموظف
        Schema::create('employee_termination_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->foreignId('requested_by')->constrained('users')->onDelete('cascade');
            $table->date('request_date');
            $table->text('reason')->comment('سبب الالغاء,مثال: غياب,تخطيط سياسة,مشكلة أداء, أخرى');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->comment('حالة الطلب');
            $table->date('approval_date')->nullable();
            $table->text('note')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_termination_requests');
    }
};
