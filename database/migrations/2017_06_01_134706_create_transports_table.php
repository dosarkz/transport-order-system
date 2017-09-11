<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transports', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('car_category_id')->nullable();
            $table->integer('car_driver_id')->nullable();
            $table->integer('car_brand_id')->nullable();
            $table->integer('car_class_type_id')->nullable();
            $table->integer('car_model_type_id')->nullable();
            $table->string('car_gos_number')->nullable();
            $table->integer('car_production_year_id')->nullable();
            $table->integer('car_hourly_price')->nullable();
            $table->integer('city_id')->nullable();
            $table->integer('car_color')->nullable();
            $table->integer('car_seats')->nullable();
            $table->integer('kind_of_property')->nullable();
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
        Schema::dropIfExists('transports');
    }
}
