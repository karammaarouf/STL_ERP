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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('employee_code', 20)->unique();
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('national_id', 50)->unique()->nullable();
            $table->date('birth_date');
            $table->enum('gender', ['M', 'F', 'Other']);
            $table->string('phone', 20);
            $table->string('email', 150)->nullable()->unique();
            $table->text('address');
            $table->foreignId('city_id')->nullable()->constrained('cities')->onDelete('set null');
            $table->foreignId('state_id')->nullable()->constrained('states')->onDelete('set null');
            $table->foreignId('country_id')->nullable()->constrained('countries')->onDelete('set null'); 
            $table->string('position_title', 100)->comment("عنوان الوظيفة"); 
            $table->date('employment_date');
            $table->enum('status', ['active', 'suspended', 'terminated'])->default('active')->comment('حالة الموظف,مفعل,معلق,منتهي')    ;
            $table->foreignId('warehouse_id')->nullable()->constrained('warehouses')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
