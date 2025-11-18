<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoice', function (Blueprint $table) {
            $table->id();
            $table->date('invoice_date');

            $table->foreignId('block_id')->constrained('blocks')->onDelete('cascade');
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');

            $table->date('from_date');
            $table->date('to_date');

            $table->decimal('house_price', 8, 2)->default(0);
            $table->decimal('wifi_price', 8, 2)->default(0);
            $table->integer('garbage_price')->default(0);

            $table->integer('old_water_number')->default(0);
            $table->integer('new_water_number')->default(0);            
            $table->integer('total_used_water')->default(0);

            $table->integer('old_electric_number')->default(0);
            $table->integer('new_electric_number')->default(0);
            $table->integer('total_used_electric')->default(0);

            $table->integer('water_unit_price')->default(0);
            $table->integer('total_amount_water')->default(0);

            $table->integer('electric_unit_price')->default(0);
            $table->integer('total_amount_electric')->default(0);
            
            $table->decimal('total_amount_usd', 8, 2)->default(0);
            $table->integer('total_amount_khr')->default(0);
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoice');
    }
};
