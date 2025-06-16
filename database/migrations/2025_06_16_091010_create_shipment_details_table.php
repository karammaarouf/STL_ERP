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
        // جدول تفاصيل الشحن
        Schema::create('shipment_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shipment_id')->constrained('shipments')->onDelete('cascade');
            $table->string('receiver_name', 150);
            $table->string('receiver_phone', 20);
            $table->text('receiver_address');
            $table->foreignId('receiver_city_id')->nullable()->constrained('cities')->onDelete('set null');
            $table->text('special_instructions')->nullable()->comment("تعليمات خاصة بالشحن");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipment_details');
    }
};
