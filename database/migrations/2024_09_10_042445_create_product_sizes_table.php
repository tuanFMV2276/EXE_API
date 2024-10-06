<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductSizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_sizes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->string('size');
            $table->string('url_3d')->nullable();
            $table->float('min_width')->nullable();;
            $table->float('max_width')->nullable();;
            $table->float('min_heigh')->nullable();;
            $table->float('max_heigh')->nullable();;
            $table->timestamps();

            // Thiết lập khóa ngoại
            $table->foreign('product_id')->references('id')->on('products')->onDelete('no action');
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_sizes');
    }
}
