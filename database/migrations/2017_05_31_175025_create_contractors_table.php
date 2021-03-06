<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contractors', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_type')->nullable();
            $table->string('company_name_full')->nullable();
            $table->string('director_name')->nullable();
            $table->string('f_director_name')->nullable();
            $table->string('fact_address')->nullable();
            $table->string('legal_address')->nullable();
            $table->unsignedBigInteger('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('description')->nullable();
            $table->string('bin')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_account')->nullable();
            $table->string('bank_bik')->nullable();
            $table->integer('nds_value')->nullable();
            $table->boolean('is_nds')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('project_id')->nullable();
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
        Schema::dropIfExists('contractors');
    }
}
