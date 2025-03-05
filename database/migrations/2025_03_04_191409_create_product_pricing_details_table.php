<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('product_pricing_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->string('component'); // Example: Gold 22KT, Labour Charges, GST
            $table->decimal('weight', 10, 2)->nullable(); // For weight-based pricing
            $table->decimal('rate', 10, 2)->nullable(); // Rate per gram
            $table->decimal('total_value', 12, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_pricing_details');
    }
};
