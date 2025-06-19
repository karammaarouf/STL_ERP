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
        // جدول لتسجيل العمليات المالية للشحنة
        Schema::create('shipment_financial_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shipment_id')->constrained('shipments')->onDelete('cascade');
            $table->enum('type', ['payment', 'refund', 'fee']);
            $table->text('description')->nullable();
            $table->decimal('amount', 15, 2);
            $table->foreignId('currency_id')->nullable()->constrained('currencies')->onDelete('set null');
            // $table->morphs('reference'); // مشكلة باضافة المورفس بهذا الشكل
            $table->string('reference_type');
            $table->unsignedBigInteger('reference_id');
            $table->index(['reference_type', 'reference_id'], 'sft_reference_index');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->decimal('exchange_rate_to_base', 15, 6)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipment_financial_transactions');
    }
};
