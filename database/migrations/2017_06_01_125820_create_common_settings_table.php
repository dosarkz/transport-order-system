<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommonSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('common_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('gps_update_interval')->nullable();
            $table->integer('route_map_update_interval')->nullable();
            $table->text('oferta_title')->nullable();
            $table->text('oferta_body')->nullable();
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
        Schema::dropIfExists('common_settings');
    }
}
