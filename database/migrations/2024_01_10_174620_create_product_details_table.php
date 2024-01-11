<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('product_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->string('size');
            $table->string('item_price');
            $table->string('discounted_price');
            $table->timestamps();
            // Define the foreign key constraint
            $table->foreign('product_id')->references('id')->on('products');
            // Add an index to the product_id column
            $table->index('product_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('product_details');
    }
};
