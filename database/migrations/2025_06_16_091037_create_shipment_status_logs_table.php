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
        // جدول لتسجيل تغيرات حالة الشحنة
        Schema::create('shipment_status_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shipment_id')->constrained('shipments')->onDelete('cascade');
            $table->enum('old_status', ['pending','on_hold', 'in_transit','out_for_delivery', 'delivered', 'cancelled', 'returned'])->default('pending')->comment("pending: قيد الانتظار, in_transit: قيد الشحن, delivered: تم التوصيل, cancelled: ملغية, returned: مرتجعة, on_hold: معلقة, out_for_delivery: خرجت للتوصيل");
            $table->enum('new_status', ['pending','on_hold', 'in_transit','out_for_delivery', 'delivered', 'cancelled', 'returned'])->default('pending')->comment("pending: قيد الانتظار, in_transit: قيد الشحن, delivered: تم التوصيل, cancelled: ملغية, returned: مرتجعة, on_hold: معلقة, out_for_delivery: خرجت للتوصيل");
            $table->foreignId('changed_by_user_id')->constrained('users')->onDelete('set null');
            $table->dateTime('changed_at')->useCurrent();
            $table->foreignId('warehouse_id')->nullable()->constrained('warehouses')->onDelete('set null');
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipment_status_logs');
    }
};
