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
        // جدول تفاصيل القطع التابعة لشحنة معينة
        Schema::create('shipment_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shipment_id')->constrained('shipments')->onDelete('cascade');
            $table->string('description', 255);
            $table->integer('quantity');
            $table->decimal('weight_per_unit', 10, 2)->nullable();
            $table->decimal('volume_per_unit', 10, 2)->nullable();
            $table->decimal('item_value', 15, 2)->nullable()->comment("قيمة العنصر");
            $table->foreignId('currency_id')->nullable()->constrained('currencies')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipment_items');
    }
};
