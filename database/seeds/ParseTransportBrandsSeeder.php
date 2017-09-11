<?php


class ParseTransportBrandsSeeder extends ParseSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('transport_brands')->truncate();
        DB::table('transport_brands')->delete();

        DB::table('transport_brand_categories')->truncate();
        DB::table('transport_brand_categories')->delete();

        $brands = $this->parse('transport_brands.json');


        if($brands)
        {
            foreach ($brands as $brand) {
              $transport_brand =   \App\Models\TransportBrand::create([
                    'id' => $brand->_id,
                    'name' => isset($brand->name) ? $brand->name : null,
                    'position' => $brand->position
                ]);

                if(isset($brand->catIds))
                {
                    foreach ($brand->catIds as $category) {

                        \App\Models\TransportBrandCategory::create([
                            'transport_brand_id' => $transport_brand->id,
                            'category_id' => $category
                        ]);
                    }
                }

            }
        }





        DB::table('transport_categories')->truncate();
        DB::table('transport_categories')->delete();

        $transport_categories = $this->parse('transport_categories.json');

        if($transport_categories)
        {
            foreach ($transport_categories as $transport_category) {
                \App\Models\TransportCategory::create([
                    'id' => $transport_category->_id,
                    'name' => $transport_category->name,
                    'position' => $transport_category->position,
                    '_image_id' => isset($transport_category->image) ? $transport_category->image : null,
                    'type_id' => $transport_category->tplId,
                ]);
            }
        }



        DB::table('transport_classes')->truncate();
        DB::table('transport_classes')->delete();

        $transport_classes = $this->parse('transport_classes.json');

        if($transport_classes)
        {
            foreach ($transport_classes as $transport_class) {
                \App\Models\TransportClass::create([
                    'id' => $transport_class->_id,
                    'name' => $transport_class->name,
                    'position' => $transport_class->position,
                    'category_id' => $transport_class->catId,
                    'type_id' => $transport_class->tplId,
                ]);
            }
        }




        DB::table('transport_models')->truncate();
        DB::table('transport_models')->delete();

        $transport_models = $this->parse('transport_models.json');

        if($transport_models)
        {
            foreach ($transport_models as $transport_model) {
                \App\Models\TransportModel::create([
                    'id' => $transport_model->_id,
                    'name' => $transport_model->name,
                    'position' => $transport_model->position,
                    'category_id' => $transport_model->catId,
                    'brand_id' => $transport_model->markaId,
                ]);
            }
        }
    }
}
