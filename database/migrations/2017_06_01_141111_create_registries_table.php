<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegistriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registries', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('start_time')->nullable();
            $table->timestamp('end_time')->nullable();
            $table->integer('order_id')->nullable();
            $table->integer('project_id')->nullable();
            $table->integer('tariff_id')->nullable();
            $table->string('tariff_name')->nullable();
            $table->integer('driver_id')->nullable();
            $table->integer('car_id')->nullable();
            $table->text('start_point')->nullable();
            $table->text('end_point')->nullable();
            $table->decimal('value',20)->nullable();
            $table->integer('work_type')->nullable();
            $table->text('comment_text')->nullable();
            $table->integer('user_id')->nullable();
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
        Schema::dropIfExists('registries');
    }
}
