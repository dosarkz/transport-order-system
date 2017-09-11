<?php


class ParseRegistriesSeeder extends ParseSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('registries')->truncate();
        DB::table('registries')->delete();

        $parse_model = $this->parse('registries.json');

        if ($parse_model)
        {
            foreach ($parse_model as $item) {
                $user = \App\Models\User::where('_id', isset($item->createdBy) ? $item->createdBy != '' ?  $item->createdBy : null : null)->first();
                $driver = \App\Models\User::where('_id', isset($item->driverId) ? $item->driverId != '' ?  $item->driverId : null : null)->first();

                \App\Models\Registry::create([
                    'start_time' =>  isset($item->startTime) ? date('Y-m-d H:i:s', (int)$item->startTime) : null,
                    'end_time'  =>  isset($item->endTime) ? date('Y-m-d H:i:s', (int)$item->endTime) : null,
                    'order_id'  =>  isset($item->orderId) ? $item->orderId : null,
                    'project_id' =>  isset($item->projectId) ? $item->projectId : null,
                    'tariff_id'  =>  isset($item->tarifId) ? $item->tarifId : null,
                    'tariff_name'  =>  isset($item->tarifName) ? $item->tarifName : null,
                    'driver_id'  =>  $driver ? $driver->id : null,
                    'car_id' => isset($item->carId) ? $item->carId != '' ?  $item->carId : null : null,
                    'start_point' => isset($item->startPoint) ? $item->startPoint != '' ?  $item->startPoint : null : null,
                    'end_point'  => isset($item->endPoint) ? $item->endPoint != '' ?  $item->endPoint : null : null,
                    'value' => isset($item->value) ? $item->value != '' ?  $item->value : null : null,
                    'work_type' => isset($item->workType) ? $item->workType != '' ?  $item->workType : null : null,
                    'comment_text' => isset($item->commentText) ? $item->commentText != '' ?  $item->commentText : null : null,
                    'created_at' => isset($item->createdAt) ? date('Y-m-d H:i:s', (int)$item->createdAt) : null,
                    'user_id' => $user ? $user->id : null,
                ]);

           }
        }
    }



}
