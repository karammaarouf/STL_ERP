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
        Schema::create('shipment_groups', function (Blueprint $table) {
            $table->id();
            $table->string('group_number', 50)->unique();
            $table->enum('group_type', ['express', 'standard', 'economy']);
            $table->foreignId('origin_warehouse_id')->constrained('warehouses')->onDelete('cascade');
            $table->foreignId('destination_warehouse_id')->constrained('warehouses')->onDelete('cascade');
            $table->decimal('total_weight', 15, 2);
            $table->decimal('total_volume', 15, 2);
            $table->string('driver_name', 100);
            $table->string('vehicle_plate', 20);
            $table->enum('status', ['pending', 'dispatched', 'delivered', 'cancelled'])->default('pending');
            $table->foreignId('created_by_user_id')->constrained('users')->onDelete('cascade');
            $table->dateTime('created_at')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipment_groups');
    }
};
