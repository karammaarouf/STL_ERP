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
        // جدول الشحنة
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->string('shipment_code', 50)->unique()->comment('كود الشحنة');
            $table->foreignId('sender_id')->constrained('customers')->onDelete('cascade')->comment('العميل المرسل للشحنة');
            $table->foreignId('from_city_id')->constrained('cities')->onDelete('cascade')->comment('المدينة القادمة منها الشحنة');
            $table->foreignId('to_city_id')->constrained('cities')->onDelete('cascade')->comment('المدينة الذاهبة اليها الشحنة');
            $table->enum('current_status', ['pending','on_hold', 'in_transit','out_for_delivery', 'delivered', 'cancelled', 'returned'])->default('pending')->comment("pending: قيد الانتظار, in_transit: قيد الشحن, delivered: تم التوصيل, cancelled: ملغية, returned: مرتجعة, on_hold: معلقة, out_for_delivery: خرجت للتوصيل");
            $table->foreignId('current_warehouse_id')->nullable()->constrained('warehouses')->onDelete('set null')->comment('المستودع الحالي');
            $table->decimal('weight', 10, 2);
            $table->decimal('volume', 10, 2);
            $table->decimal('declared_value', 15, 2)->comment("قيمة الشحنة المعلنة نقدياً");
            $table->foreignId('currency_id')->constrained('currencies')->onDelete('set null');
            $table->decimal('shipping_cost_amount', 15, 2)->comment("تكلفة الشحن");
            $table->foreignId('shipping_cost_currency_id')->constrained('currencies')->onDelete('cascade')->comment('عملة تكلفة الشحن');
            $table->enum('shipping_cost_paid_by', ['sender', 'receiver'])->comment("الجهة التي تتحمل تكلفة الشحن");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
