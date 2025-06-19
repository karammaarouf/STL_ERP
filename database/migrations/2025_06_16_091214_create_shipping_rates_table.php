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
        //جدول لتعريف تسعيرة الشحنة
        Schema::create('shipping_rates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from_country_id')->nullable()->constrained('countries')->onDelete('set null');
            $table->foreignId('to_country_id')->nullable()->constrained('countries')->onDelete('set null');
            $table->foreignId('from_city_id')->nullable()->constrained('cities')->onDelete('set null');
            $table->foreignId('to_city_id')->nullable()->constrained('cities')->onDelete('set null');
            $table->enum('shipment_type', ['air', 'sea', 'land']);
            $table->foreignId('currency_id')->nullable()->constrained('currencies')->onDelete('set null');
            $table->decimal('rate_per_kg', 15, 6)->nullable();
            $table->decimal('rate_per_volume', 15, 6)->nullable();
            $table->decimal('flat_fee', 15, 2)->nullable()->comment("مبلغ ثابت للتوصيل");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping_rates');
    }
};
