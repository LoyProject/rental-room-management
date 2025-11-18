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

            $table->unsignedInteger('house_price')->default(0);
            $table->unsignedInteger('wifi_price')->default(0);
            $table->unsignedInteger('garbage_price')->default(0);

            $table->unsignedInteger('old_water_bill')->default(0);
            $table->unsignedInteger('new_water_bill')->default(0);            
            $table->unsignedInteger('total_used_water')->default(0);

            $table->unsignedInteger('old_electric_bill')->default(0);
            $table->unsignedInteger('new_electric_bill')->default(0);
            $table->unsignedInteger('total_used_electric')->default(0);

            $table->unsignedInteger('water_unit_price')->default(0);
            $table->unsignedInteger('total_amount_water')->default(0);

            $table->unsignedInteger('electric_unit_price')->default(0);
            $table->unsignedInteger('total_amount_electric')->default(0);
            
            $table->unsignedInteger('total_amount')->default(0);
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoice');
    }
};
