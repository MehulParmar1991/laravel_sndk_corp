<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->string('brand_name');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('sub_category_id');
            $table->string('avatar');
            $table->timestamps();
            // Define the foreign key constraint
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('sub_category_id')->references('id')->on('sub_categories');           
            // Add an index to the product_id column
            $table->index('category_id');
            $table->index('sub_category_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('products');
    }
};
