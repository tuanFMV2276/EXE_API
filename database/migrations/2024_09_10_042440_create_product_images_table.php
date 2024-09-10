<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->string('image_url'); // Đường dẫn tới ảnh
            $table->timestamps();

            // Thiết lập khóa ngoại
            $table->foreign('product_id')->references('id')->on('products')->onDelete('no action');
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_images');
    }
}
