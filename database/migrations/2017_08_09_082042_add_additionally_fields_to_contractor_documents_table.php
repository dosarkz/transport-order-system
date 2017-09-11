<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAdditionallyFieldsToContractorDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contractor_documents', function(Blueprint $table){
            $table->integer('project_id')->nullable();
            $table->integer('contractor_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contractor_documents', function(Blueprint $table){
            $table->dropColumn('project_id');
            $table->dropColumn('contractor_id');
        });
    }
}
