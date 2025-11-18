<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('block_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('phone');
            $table->unsignedInteger('house_price')->default('0');
            $table->unsignedInteger('wifi_price')->default('0');
            $table->unsignedInteger('garbage_price')->default('0');
            $table->unsignedInteger('old_water_bill')->nullable();
            $table->unsignedInteger('old_electric_bill')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
