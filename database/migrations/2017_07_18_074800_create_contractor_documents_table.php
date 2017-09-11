<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractorDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contractor_documents', function (Blueprint $table) {
            $table->increments('id');
            $table->string('_id')->nullable();
            $table->timestamp('start_at')->nullable();
            $table->timestamp('stop_at')->nullable();
            $table->integer('file_type')->nullable();
            $table->string('file_type_name')->nullable();
            $table->integer('file_number')->nullable();
            $table->decimal('file_price', 20, 0)->nullable();
            $table->string('description')->nullable();
            $table->string('file_extension')->nullable();
            $table->integer('file_id');
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
        Schema::dropIfExists('contractor_documents');
    }
}
