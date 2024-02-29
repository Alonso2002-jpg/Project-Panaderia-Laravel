<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('dni')->unique();
            $table->string('email')->unique();
            $table->string('lastname');
            $table->date('startDate');
            $table->date('endDate')->nullable();
            $table->string('image');
            $table->enum('role', ['baker', 'cashier', 'manager', 'steward', 'cleaner', 'pastry_chef', 'inventory_manager'])->nullable()->default('baker');
            $table->boolean('isDelete')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staff');

    }
};
