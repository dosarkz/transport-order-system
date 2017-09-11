<?php


class ParseCitiesSeeder extends ParseSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('countries')->truncate();
        DB::table('countries')->delete();

        DB::table('regions')->truncate();
        DB::table('regions')->delete();

        DB::table('cities')->truncate();
        DB::table('cities')->delete();

        $countries = $this->parse('countries.json');

        if($countries)
        {
            foreach ($countries as $country) {
                \App\Models\Country::create([
                    'name_en' => $country->name_en,
                    'name_ru' => $country->name_ru,
                    'name_kz' => $country->name_kz,
                ]);
            }
        }

        $regions = $this->parse('regions.json');

        if ($regions)
        {
            asort($regions);
            foreach ($regions as $item) {
                \App\Models\Region::create([
                    'name_en' => $item->name_en,
                    'name_ru' => $item->name_ru,
                    'name_kz' => $item->name_kz,
                    'country_id' => $item->countryId
                ]);
            }
        }

        $cities = $this->parse('cities.json');

        if ($cities)
        {
            foreach ($cities as $item) {
                \App\Models\City::create([
                    'id' => $item->_id,
                    'name_en' => $item->name_en,
                    'name_ru' => $item->name_ru,
                    'name_kz' => $item->name_kz,
                    'country_id' => $item->countryId,
                    'region_id' => $item->regionId,
                    'latitude' => isset($item->center)  ? $item->center->lat : null,
                    'longitude' => isset($item->center) ? $item->center->lng : null,
                ]);
            }
        }
    }
}
