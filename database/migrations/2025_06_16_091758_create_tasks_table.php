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
        //جدول المهام
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title', 200);
            $table->text('description')->nullable();
            $table->foreignId('assigned_by')->constrained('users')->onDelete('cascade'); // المستخدم الذي كلف مهمة إلى آخرين 
            $table->foreignId('assigned_to')->constrained('users')->onDelete('cascade'); // المستخدم المسؤول عن تنفيذ المهمة 
            $table->enum('status', ['pending', 'in_progress', 'done', 'cancelled'])->default('pending');
            $table->foreignId('related_shipment_id')->nullable()->constrained('shipments')->onDelete('set null'); // الشحنة المرتبطة بهذا المهمة
            $table->date('due_date')->nullable()->comment('تاريخ الاستحقاق');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
