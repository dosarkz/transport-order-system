<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransportRequest;
use App\Http\Requests\UpdateTransportRequest;
use App\Models\DocumentType;
use App\Models\Image;
use App\Models\Transport;
use App\Models\TransportBrand;
use App\Models\TransportCategory;
use App\Models\TransportClass;
use App\Models\TransportDocument;
use App\Models\TransportImage;
use App\Models\TransportPrice;
use App\Models\TransportService;
use App\Models\TransportServicePriceOption;
use App\Repositories\File\DocumentFileUploader;
use Dosarkz\LaravelUploader\ImageUploader;
use Illuminate\Http\Request;

class DriverTransportsController extends Controller
{


    public function index(Request $request)
    {
        $transports = Transport::where('car_driver_id', auth()->user()->id)->get();

        return view('driver.transports.index', compact('transports'));
    }

    public function show($id)
    {
        $model = Transport::findOrFail($id);
        return view('transports.show', compact('model'));
    }

    public function create(Request $request)
    {
        if($request->has('category_id'))
        {
            $transport_category = TransportCategory::findOrFail($request->input('category_id'));
            $transport = new Transport();
            $transport_classes  = TransportClass::where('type_id', 3)->get();

            $transport_brands  = TransportBrand::whereHas('transport_brand_categories', function($query) use($transport_category){
                $query->where('category_id', $transport_category->id);
            })->orderBy('name','asc')->pluck('name','id');

            $document_types = DocumentType::pluck('name','id');
            $transport_models = [];
            $transportPrices  = TransportPrice::select('service_id')->groupBy('service_id')->get();

            return view('driver.transports.create', compact('transport_category','transport','transport_classes',
                'transport_brands','transport_models','document_types', 'transportPrices'));
        }

        return redirect()->back();
    }

    public function store(StoreTransportRequest $request)
    {
        $data = $request->all();

        $request->merge([
            'car_driver_id' => auth()->user()->id,
        ]);

        $transport = Transport::create($request->all());

        if($request->has('documents'))
        {
            foreach ($data['documents'] as $document) {
                if(!array_key_exists('document_file', $document))
                {
                    continue;
                }
                $uploader = new DocumentFileUploader($document['document_file']);

                TransportDocument::create([
                    'file_id' => $uploader->model->id,
                    'user_id' => auth()->user()->id,
                    'transport_id' => $transport->id,
                    'document_type_id' => $document['document_type'],
                    'date_to' => date('Y-m-d', strtotime($document['document_expired_at']))
                ]);
            }
        }

        foreach ($request->input('services') as $service) {

            if (array_key_exists('id', $service))
            {
                $transport_service_id = TransportService::create([
                    'transport_id' => $transport->id,
                    'service_id' => $service['id']
                ]);

                foreach ($service['options'] as $key => $priceOption) {
                    TransportServicePriceOption::create([
                        'transport_service_id' => $transport_service_id->id,
                        'transport_id' => $transport->id,
                        'price_option_id' => $key,
                        'price' => $priceOption
                    ]);
                }
            }
        }




        if($request->hasFile('transport_images'))
        {
            foreach ($request->file('transport_images') as $file) {
                $uploader = new ImageUploader($file, 'images/transports/');

                $image = Image::create([
                    'name' => $uploader->getFileName(),
                    'path' => $uploader->destination,
                    'thumb'=>  $uploader->getThumb(),
                    'user_id' => auth()->user()->id,
                ]);

                TransportImage::create([
                    'transport_id' => $transport->id,
                    'image_id' => $image->id,
                ]);
            }
        }

        return redirect('/driver/transports')->with('success', 'Транспорт успешно создан');


    }

    public function edit($id)
    {
        $transport = Transport::findOrFail($id);
        $transport_category = $transport->transportCategory;
        $transport_classes  = TransportClass::where('type_id', 3)->get();

        $transport_brands  = TransportBrand::whereHas('transport_brand_categories', function($query) use($transport_category){
            $query->where('category_id', $transport_category->id);
        })->orderBy('name','asc')->pluck('name','id');

        $transport_models = $transport->transportBrand->transportModels->pluck('name','id');
        $document_types = DocumentType::pluck('name','id');
        $transportPrices  = TransportPrice::select('service_id')->groupBy('service_id')->get();

        return view('driver.transports.edit',compact('transport_category','transport','transport_classes',
            'transport_brands','transport_models','document_types', 'transportPrices'));
    }

    public function update(UpdateTransportRequest $request, $id)
    {
        $data = $request->all();
        $transport = Transport::findOrFail($id);
        $transport->update($request->except('documents'));


        if($request->has('image_on_main'))
        {
            $transport->transportImages()->update([
                'is_main' => 0
            ]);

            $transportImage =  TransportImage::findOrFail($request->input('image_on_main'));
            $transportImage->update(['is_main' => true]);
        }

        if($request->has('documents'))
        {
            foreach ($data['documents'] as $document) {
                if(!array_key_exists('document_file', $document)){
                    continue;
                }

                $uploader = new DocumentFileUploader($document['document_file']);

                TransportDocument::create([
                    'file_id' => $uploader->model->id,
                    'user_id' => auth()->user()->id,
                    'transport_id' => $transport->id,
                    'document_type_id' => $document['document_type'],
                    'date_to' => date('Y-m-d', strtotime($document['document_expired_at']))
                ]);
            }
        }

        if($request->hasFile('transport_images'))
        {
            foreach ($request->file('transport_images') as $file) {
                $uploader = new ImageUploader($file, 'images/transports/');

                $image = Image::create([
                    'name' => $uploader->getFileName(),
                    'path' => $uploader->destination,
                    'thumb'=>  $uploader->getThumb(),
                    'user_id' => auth()->user()->id,
                ]);

                TransportImage::create([
                    'transport_id' => $transport->id,
                    'image_id' => $image->id,
                ]);
            }
        }

        $transport->transportServices()->delete();
        $transport->transportPriceOptions()->delete();

        foreach ($request->input('services') as $service) {

            if (array_key_exists('id', $service))
            {
                $transport_service_id = TransportService::firstOrCreate([
                    'transport_id' => $transport->id,
                    'service_id' => $service['id']
                ]);

                foreach ($service['options'] as $key => $priceOption) {
                    $transportServicePriceOption = TransportServicePriceOption::firstOrCreate([
                        'transport_service_id' => $transport_service_id->id,
                        'transport_id' => $transport->id,
                        'price_option_id' => $key,
                    ]);

                    $transportServicePriceOption->update([
                        'price' => (int)$priceOption
                    ]);
                }
            }
        }

        return redirect('/driver/transports')->with('success', 'Транспорт успешно создан');
    }

    public function chooseCategory()
    {
        $transport_categories = TransportCategory::orderBy('name', 'asc')->get();
        return view('driver.transports.choose_category', compact('transport_categories'));
    }

    public function destroy($id)
    {
        $model = Transport::findOrFail($id);
        $model->transportImages()->delete();
        $model->transportServices()->delete();
        $model->transportDocument()->delete();

        $model->delete();
        return redirect()->back()->with('success','Успешно удалено');

    }

}
