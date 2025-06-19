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
        //جدول المواد المضافة للموظف(العهد التي يستلمها الموظف)
        Schema::create('employee_assets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->integer('quantity');
            $table->date('assigned_date'); 
            $table->date('returned_date')->nullable();
            $table->enum('status', ['in_use', 'returned', 'lost', 'repair'])->comment('حالة المواد, في الاستخدام, تم إرجاعها, فقدتها, بحاجة للتعليق');
            $table->text('note')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_assets');
    }
};
