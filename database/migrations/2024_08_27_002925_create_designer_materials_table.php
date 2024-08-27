<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDesignerMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('designer_materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('designer_id')->constrained()->onDelete('no action');
            $table->foreignId('material_id')->constrained()->onDelete('no action');
            $table->integer('quantity_requested');
            $table->dateTime('request_date')->default(now());
            $table->enum('status', ['Pending', 'Approved', 'Rejected'])->default('Pending');
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
        Schema::dropIfExists('designer_materials');
    }
}
