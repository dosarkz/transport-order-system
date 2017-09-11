<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Transport;
use App\Models\TransportBrand;
use App\Models\TransportCategory;
use App\Models\TransportModel;
use Illuminate\Http\Request;

class TransportController extends Controller
{


    public function index(Request $request)
    {
        $transport_categories = TransportCategory::orderBy('name','asc')->pluck('name','id');
        $transport_brands  = TransportBrand::whereHas('transport_brand_categories', function($query) use($request){
            $query->where('category_id', $request->input('transport-category'));
        })
            ->orderBy('name','asc')->pluck('name','id');

        $transport_models = [];

        $model = Transport::whereHas('transportServices', function($query) use ($request)
        {
            $query->where('service_id',$request->input('service_id'));
        });

        if($request->has('category_id'))
        {
            $model = Transport::where('car_category_id', $request->input('category_id'));
        }

        if($request->has('fio'))
        {
            $fio = $request->input('fio');
            $model->whereHas('driver', function($query) use($fio){
                $query->where('last_name', 'like',"%$fio%")
                    ->orWhere('first_name','like', "%$fio%");
            });
        }

        if($request->has('phone'))
        {
            $phone = purify_phone_number($request->input('phone'));

           if(strlen($phone) == 11)
           {
               $phone = substr($phone, 1, 10);
           }

            $model->whereHas('driver', function($query) use($phone){
                $query->where('phone', 'like',"%$phone%");
            });
        }

        if($request->has('transport-category'))
        {
            $model->where('car_category_id', $request->input('transport-category'));
        }

        if($request->has('city_id'))
        {
            $model->where('city_id', $request->input('city_id'));
        }else{
            $city = auth()->user()->city_id ? auth()->user()->city_id : 10;
            $model->where('city_id', $city);
        }

        if($request->has('transport-brand'))
        {
            $model->whereHas('transportBrand', function($query) use($request){
                $query->where('id', $request->input('transport-brand'));
            });

            $transport_models = TransportModel::where('brand_id', $request->input('transport-brand'))
                ->where('category_id', $request->input('transport-category'))
                ->orderBy('name','asc')->pluck('name','id');
        }

        if($request->has('transport-model'))
        {
            $model->where('car_model_type_id', $request->input('transport-model'));
        }

        if($request->has('production-year'))
        {
            $model->where('car_production_year_id', $request->input('production-year'));
        }

        if($request->has('gos-number'))
        {
            $gos_number = $request->input('gos-number');
            $model->where('car_gos_number','like',"%$gos_number%");
        }

        $model = $model->paginate(20);

        if($request->has('category_id'))
        {
            $service = TransportCategory::findOrFail($request->input('category_id'));
            return view('transports.index', compact('model', 'service','transport_categories','transport_brands',
                'transport_models'));
        }

        $service = Service::findOrFail($request->input('service_id'));

        return view('transports.index', compact('model', 'service', 'transport_categories','transport_brands',
            'transport_models'));
    }

    public function show($id)
    {
        $model = Transport::findOrFail($id);

        return view('transports.show', compact('model'));
    }
}
