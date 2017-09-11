<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransportCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transport_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->integer('position')->nullable();
            $table->integer('image_id')->nullable();
            $table->integer('type_id')->nullable();
            $table->string('_image_id')->nullable();
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
        Schema::dropIfExists('transport_categories');
    }
}
