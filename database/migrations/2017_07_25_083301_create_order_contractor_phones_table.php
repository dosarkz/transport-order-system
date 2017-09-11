<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderContractorPhonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_contractor_phones', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id');
            $table->integer('project_id')->nullable();
            $table->integer('contractor_id')->nullable();
            $table->unsignedBigInteger('phone');
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
        Schema::dropIfExists('order_contractor_phones');
    }
}
