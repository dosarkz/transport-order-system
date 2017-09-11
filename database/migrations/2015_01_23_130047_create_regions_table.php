<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRegionsTable extends Migration {

	public function up()
	{
		Schema::create('regions', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('country_id')->unsigned()->index();
			$table->string('name_en', 255);
			$table->string('name_ru', 255);
			$table->string('name_kz', 255);
		});
	}

	public function down()
	{
        Schema::table('regions', function(Blueprint $table) {
            $table->drop();
        });
	}
}