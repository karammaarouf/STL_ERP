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
        //جدول كسر علاقة بين الطبلية والرفوف,كل طبلية توزع على اكثر من رف و كل رف يحتوي على بضاعة من اكثر من طبلية
        Schema::create('pallet_warehouse_slots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('warehouse_slot_id')->constrained('warehouse_slots')->onDelete('cascade');
            $table->foreignId('pallet_id')->constrained('pallets')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pallet_warehouse_slots');
    }
};
