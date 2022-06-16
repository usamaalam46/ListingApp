<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('sku');
            $table->string('slug');
            $table->string('title');
            $table->string('title_arabic');
            $table->string('description');
            $table->string('description_arabic');
            $table->string('image');
            $table->integer('price');
            $table->boolean('is_discounted')->default(0);
            $table->integer('discounted_price')->nullable();
            $table->boolean('is_featured')->default(0);
            $table->integer('search_counter')->default(0);
            $table->integer('active')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
