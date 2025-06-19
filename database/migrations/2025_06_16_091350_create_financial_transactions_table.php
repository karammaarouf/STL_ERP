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
        // جدول العمليات المالية
        Schema::create('financial_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from_account_id')->nullable()->constrained('financial_accounts')->onDelete('set null');
            $table->foreignId('to_account_id')->nullable()->constrained('financial_accounts')->onDelete('set null');
            $table->decimal('amount', 15, 2);
            $table->foreignId('currency_id')->nullable()->constrained('currencies')->onDelete('set null');
            $table->decimal('exchange_rate_to_base', 15, 6)->nullable();
            $table->enum('transaction_type', ['debit', 'credit', 'transfer'])->comment('نوع العملية, مثال: دفع, استلام, تحويل');
            $table->enum('transaction_category', ['salary', 'shipment_fee', 'tax', 'expense', 'refund', 'other'])->comment('فئة العملية, مثال: راتب, رسوم الشحنة, ضريبة, مصروف, مرتجع, أخرى');
            $table->text('description')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->string('related_entity_type', 50)->nullable();
            $table->string('related_entity_id', 50)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_transactions');
    }
};
