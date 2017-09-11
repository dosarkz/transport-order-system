<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContinentsTable extends Migration {

	public function up()
	{
		Schema::create('continents', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name_en', 255);
			$table->string('name_ru', 255);
			$table->string('name_kz', 255);
		});
	}

	public function down()
	{
		Schema::drop('continents');
	}
}