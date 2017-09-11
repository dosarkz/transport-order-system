<?php


class ParseOrdersSeeder extends ParseSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('orders')->truncate();
        DB::table('orders')->delete();

        $orders = $this->parse('orders.json');

        if ($orders)
        {
            foreach ($orders as $order) {

                if(isset($order->order))
                {
                    $type = \App\Models\Order::TYPE_CLIENT_ORDER;

                    if($order->order->type == 'orderservice')
                    {
                        $type = \App\Models\Order::TYPE_ORDER_SERVICE;
                    }

                    $driver = \App\Models\User::where('_id', isset($order->order->driver->_id) ? $order->order->driver->_id : null)->first();
                    $contractor_document = \App\Models\ContractorDocument::where('_id', isset($order->order->clientDocumentId) ? $order->order->clientDocumentId : null)->first();
                    $project_service  = \App\Models\ProjectService::where('_id', isset($order->order->orderServiceId) ? $order->order->orderServiceId : null)->first();
                    $user = \App\Models\User::where('_id',$order->createdBy)->first();

                    \App\Models\Order::create([
                        'id' => isset($order->_id) ? (int)$order->_id : null,
                        'type_id' => $type,
                        'date_start' =>  isset($order->order->startDate) ? $order->order->startDate != '' ? date('Y-m-d H:i:s', $order->order->startDate) : null : null,
                        'date_end' =>  isset($order->order->endDate) ? $order->order->endDate != '' ? date('Y-m-d H:i:s', $order->order->endDate) : null : null,
                        'start_point_text' => isset($order->order->startPoint->text) ? $order->order->startPoint->text : null,
                        'start_point_latitude' => isset($order->order->startPoint->lat) ? $order->order->startPoint->lat != '' ?  $order->order->startPoint->lat : null : null,
                        'start_point_longitude' => isset($order->order->startPoint->lng) ?  $order->order->startPoint->lng != '' ?  $order->order->startPoint->lng : null : null,
                        'end_point_text' => isset($order->order->endPoint->text) ? $order->order->endPoint->text : null,
                        'end_point_latitude' => isset($order->order->endPoint->lat) ? $order->order->endPoint->lat != '' ?  $order->order->endPoint->lat : null : null,
                        'end_point_longitude' => isset($order->order->endPoint->lng) ? $order->order->endPoint->lng != '' ?  $order->order->endPoint->lng : null : null,
                        'description' =>  isset($order->order->description) ? $order->order->description : null,
                        'status_id' => isset($order->order->status) ? $order->order->status : null,
                        'service_id' => isset($order->order->serviceId) ? $order->order->serviceId != '' ? $order->order->serviceId : null : null,
                        'client_price' => isset($order->order->client->price) ? $order->order->client->price != '' ? (int)$order->order->client->price : null : null,
                        'client_phone' => $order->order->client->phone,
                        'driver_id' => $driver ? $driver->id : null,
                        'driver_price' => isset($order->order->driver->price ) ?  $order->order->driver->price != '' ? (int)$order->order->driver->price : null : null,
                        'client_document_id' => $contractor_document ? $contractor_document->id : null,
                        'client_document_type' => isset($order->order->clientDocumentType) ? (int)$order->order->clientDocumentType : null,
                        'client_document_text' => isset($order->order->clientDocumentText) ? $order->order->clientDocumentText : null,
                        'order_service_id' => $project_service ? $project_service->id : null,
                        'order_service_name' => isset($order->order->orderServiceName) ? $order->order->orderServiceName : null,
                        'driver_contractor_id' => isset($order->order->driverContragentId)  ? $order->order->driverContragentId != '' ? $order->order->driverContragentId : null : null,
                        'driver_contractor_text' => isset($order->order->driverContragentText) ? $order->order->driverContragentText : null,
                        'car_id' => isset($order->order->carId) ? $order->order->carId != '' ? $order->order->carId : null : null,
                        'car_category_id' => isset($order->order->carCatId) ? $order->order->carCatId != '' ? $order->order->carCatId : null : null,
                        'car_brand_id' => isset($order->order->carMarkaId) ? $order->order->carMarkaId != '' ? $order->order->carMarkaId : null : null,
                        'car_model_id' => isset($order->order->carModelId) ? $order->order->carModelId != '' ? !is_array($order->order->carModelId) ?  $order->order->carModelId : null : null : null,
                        'amount' => isset($order->order->value) ? $order->order->value : null,
                        'amount_of_work' => isset($order->order->workSeconds) ? $order->order->workSeconds : null,
                        'tariff_id' => isset($order->order->tarif) ? $order->order->tarif : null,
                        'city_id' => isset($order->order->cityId) ? $order->order->cityId != '' ? $order->order->cityId : null : null,
                        'project_id' => isset($order->order->projectId) ? $order->order->projectId : null,
                        'contractor_id' => isset($order->order->contragentId) ?  $order->order->contragentId != '' ? $order->order->contragentId : null : null,
                        'client_accepted_at' => isset($order->order->accepted) ? $order->order->accepted != '' ? date('Y-m-d H:i:s', $order->order->accepted) : null : null,
                        'user_id' => $user ? $user->id : null,
                        'created_at' => date('Y-m-d H:i:s', $order->createdAt)
                    ]);

                }
           }
        }
    }



}
