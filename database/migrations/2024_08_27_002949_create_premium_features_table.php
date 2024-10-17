<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePremiumFeaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('premium_features', function (Blueprint $table) {
            $table->id();
            $table->string('feature_name');
            $table->text('description')->nullable();
            $table->decimal('price', 8, 2);
            $table->integer('duration_days');
            $table->boolean('is_feature')->default(true);
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
        Schema::dropIfExists('premium_features');
    }
}
