<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectOperatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_operators', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id');
            $table->integer('user_id')->nullable();
            $table->unsignedBigInteger('phone')->nullable();
            $table->string('post_text')->nullable();
            $table->integer('post_id')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
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
        Schema::dropIfExists('project_operators');
    }
}
