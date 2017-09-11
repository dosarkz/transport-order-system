<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(ParseCitiesSeeder::class);
        $this->call(ParseUsersSeeder::class);
        $this->call(ParseTransportSeeder::class);
        $this->call(ParseCommonSeeder::class);
        $this->call(ParseTransportBrandsSeeder::class);
        $this->call(DriverServicesTableSeeder::class);
        $this->call(TransportPricesSeeder::class);
        $this->call(ParseProjectsSeeder::class);
        $this->call(ParseContractorsSeeder::class);
        $this->call(ParseOrdersSeeder::class);
        $this->call(ParseRegistriesSeeder::class);
    }
}
