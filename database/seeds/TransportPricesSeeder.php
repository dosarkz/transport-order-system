<?php

use Illuminate\Database\Seeder;

class TransportPricesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('transport_prices')->truncate();
        DB::table('transport_prices')->delete();

        $services = \App\Models\Service::all();

        foreach ($services as $service) {
            if($service->id == 1)
            {
                \App\Models\TransportPrice::create([
                    'service_id' => $service->id,
                    'price_option_id' =>  1
                ]);

                \App\Models\TransportPrice::create([
                    'service_id' => $service->id,
                    'price_option_id' =>  2
                ]);

                \App\Models\TransportPrice::create([
                    'service_id' => $service->id,
                    'price_option_id' =>  5
                ]);
            }

            if($service->id == 2)
            {
                \App\Models\TransportPrice::create([
                    'service_id' => $service->id,
                    'price_option_id' =>  4
                ]);
            }

            if($service->id == 5)
            {
                \App\Models\TransportPrice::create([
                    'service_id' => $service->id,
                    'price_option_id' =>  1
                ]);

                \App\Models\TransportPrice::create([
                    'service_id' => $service->id,
                    'price_option_id' =>  3
                ]);

                \App\Models\TransportPrice::create([
                    'service_id' => $service->id,
                    'price_option_id' =>  4
                ]);
            }

            if($service->id == 7)
            {
                \App\Models\TransportPrice::create([
                    'service_id' => $service->id,
                    'price_option_id' =>  4
                ]);
            }

            if($service->id == 9)
            {
                \App\Models\TransportPrice::create([
                    'service_id' => $service->id,
                    'price_option_id' =>  4
                ]);
            }

            if($service->id == 12)
            {
                \App\Models\TransportPrice::create([
                    'service_id' => $service->id,
                    'price_option_id' =>  5
                ]);
            }

            if($service->id == 13)
            {
                \App\Models\TransportPrice::create([
                    'service_id' => $service->id,
                    'price_option_id' =>  4
                ]);
            }

        }


    }
}
