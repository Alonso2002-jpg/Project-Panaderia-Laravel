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
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('description', 1000)->default(" ");
            $table->string('name',120)->unique();
            $table->decimal('price', 8,2)->default(0.0);
            $table->integer('stock')->default(0);
            $table->string('image')->default('https://static.vecteezy.com/system/resources/previews/005/337/799/non_2x/icon-image-not-found-free-vector.jpg');
            $table->foreignId('category_id')->references('id')->on('categories');
            $table->foreignId('provider_id')->references('id')->on('providers');
            $table->boolean('isDeleted')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
