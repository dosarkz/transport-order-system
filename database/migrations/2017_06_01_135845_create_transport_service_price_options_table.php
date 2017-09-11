<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransportServicePriceOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transport_service_price_options', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('transport_service_id');
            $table->integer('transport_id');
            $table->integer('price')->nullable();
            $table->integer('price_option_id')->nullable();
            $table->integer('status_id')->nullable();
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
        Schema::dropIfExists('transport_service_price_options');
    }
}
