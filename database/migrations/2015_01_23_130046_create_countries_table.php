<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCountriesTable extends Migration
{

    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('continent_id')
                ->unsigned()
                ->index()
                ->nullable();
            $table->string('name_en', 255);
            $table->string('name_ru', 255);
            $table->string('name_kz', 255);
            $table->string('code', 2)->nullable();
        });
    }

    public function down()
    {

        Schema::table('countries', function (Blueprint $table) {
            $table->drop();
        });
    }
}