<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTransportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_transports', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id');
            $table->integer('project_id')->nullable();
            $table->integer('transport_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('driver_id')->nullable();
            $table->integer('transport_category_id')->nullable();
            $table->integer('transport_brand_id')->nullable();
            $table->integer('transport_model_id')->nullable();
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
       Schema::dropIfExists('order_transports');
    }
}
