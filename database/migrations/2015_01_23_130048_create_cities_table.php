<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCitiesTable extends Migration {

	public function up()
	{
		Schema::create('cities', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('region_id')->unsigned()->index()->nullable();
			$table->integer('country_id')->unsigned()->index()->nullable();
            $table->string('name_en', 255);
			$table->string('name_ru', 255);
			$table->string('name_kz', 255);
			$table->decimal('latitude', 11, 8)->nullable();
			$table->decimal('longitude', 11, 8)->nullable();
			$table->softDeletes();
		});
	}

	public function down()
	{
        Schema::table('cities', function(Blueprint $table) {
            $table->drop();
        });
	}
}