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
            $table->decimal('house_price', 8, 2)->default(0);
            $table->decimal('wifi_price', 8, 2)->default(0);
            $table->integer('garbage_price')->default(0);
            $table->integer('old_water_number')->nullable();
            $table->integer('old_electric_number')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
