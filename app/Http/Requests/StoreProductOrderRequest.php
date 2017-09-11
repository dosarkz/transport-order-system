<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'date_start' => 'required',
            'date_end' => 'required',
            'city_id' => 'required',
            'order_service_id' => 'required',
            'start_point_text' => 'required',
            'end_point_text' => 'required',
            'tariff_id'  => 'required',
            'client_price'  => 'required',
            'driver_price'  => 'required',
            'car_id' => 'required'
        ];

//        if($this->transports)
//        {
//            foreach ($this->transports as $i => $transport) {
//                $rules['transports.'.$i.'.transport-category'] = 'required';
//                $rules['transports.'.$i.'.transport-brand'] = 'required';
////                $rules['transports.'.$i.'.transport-model'] = 'required';
//            }
//        }else{
//            $rules['transports.1.transport-category'] = 'required';
//            $rules['transports.1.transport-brand'] = 'required';
////            $rules['transports.1.transport-model'] = 'required';
//        }


        return $rules;
    }
}
