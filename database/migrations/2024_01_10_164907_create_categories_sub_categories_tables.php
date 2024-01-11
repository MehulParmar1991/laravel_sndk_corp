<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('sub_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('category_id');
            $table->timestamps();
            // Define the foreign key constraint
            $table->foreign('category_id')->references('id')->on('categories');
            // Add an index to the category_id column
            $table->index('category_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('categories');
        Schema::dropIfExists('sub_categories');
    }
};
