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
        Schema::create('financial_accounts', function (Blueprint $table) {
            $table->id();
            $table->enum('account_type', ['employee', 'warehouse', 'customer']);
            $table->unsignedBigInteger('account_entity_id')->comment('معرف الحساب');
            $table->foreignId('currency_id')->nullable()->constrained('currencies')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();

            // ملاحظة:
            // هذه الجداول تتطلب علاقات Polymorphic.
            // لا يمكن تعريف المفاتيح الأجنبية بهذه الطريقة مباشرة في Migration لـ account_entity_id
            // حيث أن account_entity_id يمكن أن يشير إلى employees.id أو warehouses.id أو customers.id. 
            // ستحتاج إلى إدارة هذه العلاقة على مستوى الـ Model باستخدام MorphTo. 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_accounts');
    }
};
