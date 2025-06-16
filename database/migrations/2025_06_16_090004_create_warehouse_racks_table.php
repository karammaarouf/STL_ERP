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
        //جدول لتقسيم الاقسام الى رفوف
        Schema::create('warehouse_racks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')->constrained('warehouse_sections')->onDelete('cascade');
            $table->string('code', 50)->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warehouse_racks');
    }
};
