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
            $table->foreignId('designer_id')->constrained()->onDelete('no action');
            $table->string('product_name');
            $table->string('category')->nullable();
            $table->string('sub_category')->nullable();
            $table->text('description')->nullable();
            $table->decimal('price', 18, 2);
            $table->decimal('sale', 8, 2)->nullable();
            $table->boolean('is_bestSeller')->default(false);
            $table->boolean('is_premium')->default(false);
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
