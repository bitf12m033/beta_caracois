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
            $table->string('brand_name')->nullable();
            $table->string('product_name')->nullable();
            $table->string('category')->nullable();
            $table->string('receive_date')->nullable();
            $table->string('expired_date')->nullable();
            $table->double('original_price')->nullable();
            $table->double('sell_price')->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('quantity_left')->nullable();
            $table->double('total')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->tinyInteger('is_active')->default(1);
            $table->tinyInteger('is_delete')->default(0);

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
