<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable();
            $table->integer('type_id')->nullable();
            $table->integer('service_id')->nullable();
            $table->timestamp('date_start')->nullable();
            $table->timestamp('date_end')->nullable();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('phone')->nullable();
            $table->string('device')->nullable();
            $table->integer('car_id')->nullable();
            $table->integer('car_category_id')->nullable();
            $table->integer('car_brand_id')->nullable();
            $table->integer('car_model_id')->nullable();
            $table->double('amount_of_work')->nullable();
            $table->unsignedBigInteger('car_production_year_id')->nullable();
            $table->decimal('amount')->nullable();
            $table->integer('tariff_id')->nullable();
            $table->integer('city_id')->nullable();
            $table->integer('project_id')->nullable();
            $table->integer('contractor_id')->nullable();
            $table->timestamp('client_accepted_at')->nullable();
            $table->integer('finished_user_id')->nullable();
            $table->timestamp('finished_at')->nullable();
            $table->timestamp('canceled_at')->nullable();
            $table->timestamp('canceled_user_id')->nullable();
            $table->string('start_point_text')->nullable();
            $table->decimal('start_point_latitude', 11, 8)->nullable();
            $table->decimal('start_point_longitude', 11, 8)->nullable();
            $table->string('end_point_text')->nullable();
            $table->decimal('end_point_latitude', 11, 8)->nullable();
            $table->decimal('end_point_longitude', 11, 8)->nullable();
            $table->unsignedBigInteger('client_price')->nullable();
            $table->unsignedBigInteger('client_phone')->nullable();
            $table->integer('driver_id')->nullable();
            $table->integer('driver_price')->nullable();
            $table->integer('client_document_id')->nullable();
            $table->string('client_document_text')->nullable();
            $table->string('client_document_type')->nullable();
            $table->integer('order_service_id')->nullable();
            $table->string('order_service_name')->nullable();
            $table->integer('driver_contractor_id')->nullable();
            $table->string('driver_contractor_text')->nullable();
            $table->integer('status_id')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('orders');
    }
}
