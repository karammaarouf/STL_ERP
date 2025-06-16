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
        //جدول لتقسيم الرفوف الى قطع
        Schema::create('warehouse_slots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rack_id')->constrained('warehouse_racks')->onDelete('cascade');
            $table->string('code', 50)->unique();
            $table->decimal('max_weight', 15, 2);
            $table->decimal('max_volume', 15, 2);
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
        Schema::dropIfExists('warehouse_slots');
    }
};
