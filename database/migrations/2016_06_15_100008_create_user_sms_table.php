<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserSmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_sms', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('code')->nullable();
            $table->string('phone_number')->nullable()->unique();
            $table->boolean('status_id')->default(false);
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
        Schema::drop('user_sms');
    }
}
