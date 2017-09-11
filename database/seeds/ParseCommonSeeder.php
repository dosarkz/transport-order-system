<?php


class ParseCommonSeeder extends ParseSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('common_settings')->truncate();
        DB::table('common_settings')->delete();

        DB::table('driver_licenses')->truncate();
        DB::table('driver_licenses')->delete();

        DB::table('car_types')->truncate();
        DB::table('car_types')->delete();

        DB::table('price_options')->truncate();
        DB::table('price_options')->delete();

        DB::table('order_statuses')->truncate();
        DB::table('order_statuses')->delete();

        DB::table('colors')->truncate();
        DB::table('colors')->delete();

        DB::table('recall_types')->truncate();
        DB::table('recall_types')->delete();

        DB::table('car_bodies')->truncate();
        DB::table('car_bodies')->delete();

        DB::table('company_types')->truncate();
        DB::table('company_types')->delete();

        DB::table('document_types')->truncate();
        DB::table('document_types')->delete();

        DB::table('contractor_file_types')->truncate();
        DB::table('contractor_file_types')->delete();


        $common = $this->parseObject('common.json');

        if ($common)
        {
            \App\Models\CommonSetting::create([
                'gps_update_interval' => $common->data->gpsUpdateInterval,
                'route_map_update_interval' => $common->data->routeMapUpdateInterval,
                'oferta_title' => $common->data->oferta->ru->title,
                'oferta_body' => $common->data->oferta->ru->body,
            ]);

            foreach ($common->data->driverLicenses as $driverLicense) {
                \App\Models\DriverLicense::create([
                    'id' => $driverLicense->id,
                    'name' => $driverLicense->name
                ]);
            }

            foreach ($common->data->carTplList as $car_type) {
                \App\Models\CarType::create([
                    'id' => $car_type->tplId,
                    'name' => $car_type->tplName
                ]);
            }

            foreach ($common->data->priceOptions as $priceOption) {
                \App\Models\PriceOption::create([
                    'id' => $priceOption->optPriceId,
                    'name' => $priceOption->optPriceName
                ]);
            }

            foreach ($common->data->orderStatusList as $orderStatus) {
                \App\Models\OrderStatus::create([
                    'status_id' => $orderStatus->statusId,
                    'active' => $orderStatus->active,
                    'status_text' => $orderStatus->statusText
                ]);
            }

            foreach ($common->data->colorSet as $colorSet) {
                \App\Models\Color::create([
                    'name' => $colorSet->name,
                    'value' => $colorSet->value
                ]);
            }

            foreach ($common->data->recallTypes as $recallType) {
                \App\Models\RecallType::create([
                    'id' => $recallType->id,
                    'type' => $recallType->type,
                    'title' => $recallType->title,
                ]);
            }

            foreach ($common->data->car_body as $car_body) {
                \App\Models\CarBody::create([
                    'id' => $car_body->id,
                    'name' => $car_body->name,
                ]);
            }

            foreach ($common->data->companytypes as $company_type) {
                \App\Models\CompanyType::create([
                    'id' => $company_type->id,
                    'name' => $company_type->name,
                ]);
            }

            foreach ($common->data->documentTypes as $documentType) {
                \App\Models\DocumentType::create([
                    'id' => $documentType->id,
                    'name' => $documentType->name,
                    'type' => $documentType->type,
                ]);
            }

            foreach ($common->data->contragentFileTypes as $contractorFileType) {
                \App\Models\ContractorFileType::create([
                    'id' => $contractorFileType->id,
                    'name' => $contractorFileType->name,
                ]);
            }












        }
    }



}
