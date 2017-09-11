<?php


class ParseTransportSeeder extends ParseSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('transports')->truncate();
        DB::table('transports')->delete();

        DB::table('transport_images')->truncate();
        DB::table('transport_images')->delete();

        DB::table('transport_services')->truncate();
        DB::table('transport_services')->delete();

        DB::table('transport_service_price_options')->truncate();
        DB::table('transport_service_price_options')->delete();

        $transports = $this->parse('transports.json');

        if ($transports)
        {
            foreach ($transports as $item) {

                if (isset($item->baseFields->carDriverId))
                {
                    $driver = \App\Models\User::where('_id', $item->baseFields->carDriverId)->first();
                }else{
                    $driver = \App\Models\User::Where('_id', isset($item->createdBy) ? $item->createdBy : null)->first();
                }

             $transport =  \App\Models\Transport::create([
                    'car_category_id' => isset($item->baseFields->carCatId) ? $item->baseFields->carCatId : null,
                    'car_driver_id' => $driver ? $driver->id : null,
                    'car_brand_id' =>  isset($item->baseFields->carMarkaId)  && $item->baseFields->carMarkaId != '' ? $item->baseFields->carMarkaId : null,
                    'car_class_type_id' => isset($item->baseFields->carClassTplId) ? $item->baseFields->carClassTplId : null,
                    'car_model_type_id' =>  isset($item->baseFields->carModelId) && $item->baseFields->carModelId != '' ? $item->baseFields->carModelId : null,
                    'car_gos_number' =>  isset($item->baseFields->carGosNomer) ? $item->baseFields->carGosNomer : null,
                    'car_production_year_id' =>  isset($item->baseFields->carProductionYear)   ?  strlen($item->baseFields->carProductionYear) < 5 ? $item->baseFields->carProductionYear: null : null,
                    'car_hourly_price' =>  isset($item->baseFields->carHourlyPrice) ? $item->baseFields->carHourlyPrice : null,
                    'city_id' => isset($item->baseFields->cityId) && $item->baseFields->cityId != '' ? $item->baseFields->cityId : null,
                    'car_seats' => isset($item->baseFields->carSeats) ? $item->baseFields->carSeats : null,
                    'car_color' => isset($item->baseFields->carColor) ? $item->baseFields->carColor : null,
                ]);

                if(isset($item->images))
                {
                    foreach ($item->images as $image) {
                        \App\Models\TransportImage::create([
                           'transport_id' =>  $transport->id,
                            '_public_image_id' =>  isset($image->public_id) ? $image->public_id : null,
                            'is_main' => isset($image->is_main) ? $image->is_main : null
                        ]);
                    }
                }


                if(isset($item->services))
                {
                    foreach ($item->services as $service) {
                        if(is_array($service->serviceId))
                        {
                            foreach ($service->serviceId as $service_id) {
                                $transport_service_id = \App\Models\TransportService::create([
                                    'transport_id' => $transport->id,
                                    'service_id' => $service_id
                                ]);
                           }
                        }else{
                            $transport_service_id = \App\Models\TransportService::create([
                                'transport_id' => $transport->id,
                                'service_id' => $service->serviceId
                            ]);
                        }


                        if(isset($service->priceOptions))
                        {
                            foreach ($service->priceOptions as $priceOption) {
                                \App\Models\TransportServicePriceOption::create([
                                    'transport_service_id' => $transport_service_id->id,
                                    'transport_id' => $transport->id,
                                    'price_option_id' => $priceOption->id,
                                    'price' => $priceOption->price
                                ]);

                            }
                        }
                    }
                }

            }
        }
    }



}
