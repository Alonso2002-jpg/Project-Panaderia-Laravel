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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users');
            $table->string('name', 50);
            $table->string('lastName', 75);
            $table->string('dni', 9);
            $table->string('street', 100);
            $table->string('number', 7)->nullable();
            $table->string('city', 50);
            $table->string('province', 70);
            $table->string('country', 50);
            $table->string('postCode',5);
            $table->string('additionalInfo', 150)->default(" ");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
