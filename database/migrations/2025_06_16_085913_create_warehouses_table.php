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
        Schema::create('warehouses', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('code', 50)->unique();
            $table->foreignId('city_id')->constrained('cities')->onDelete('cascade');
            $table->enum('type', ['main', 'branch'])->comment("نوع المستودع الرئيسي او فرعي");
            $table->decimal('total_capacity_weight', 15, 2)->default(0);
            $table->decimal('total_capacity_volume', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warehouses');
    }
};
