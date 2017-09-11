<?php

use Illuminate\Database\Seeder;

class DriverServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('driver_services')->truncate();
        DB::table('driver_services')->delete();

        \App\Models\DriverService::create([
            'name' => 'Услуги водителя',
            'status_id' => true,
        ]);

        \App\Models\DriverService::create([
            'name' => 'Трезвый водитель',
            'status_id' => true,
        ]);
    }
}
