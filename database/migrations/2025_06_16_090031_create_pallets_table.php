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
        // جدول الطبلية التي تجمع الشحنة لتوزيعها على الرفوف
        Schema::create('pallets', function (Blueprint $table) {
            $table->id();
            $table->string('barcode', 100)->unique();
            $table->foreignId('warehouse_id')->constrained('warehouses')->onDelete('cascade');
            $table->enum('status', ['empty', 'loaded', 'reserved'])->default('empty')->comment("empty: غير محجوزة, loaded: محجوزة, reserved: محجوزة مؤقتا");
            $table->decimal('current_weight', 15, 2)->default(0.00);
            $table->decimal('current_volume', 15, 2)->default(0.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pallets');
    }
};
