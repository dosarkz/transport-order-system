<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransportRequest extends FormRequest
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
            'transport_images' => 'required',
            'car_brand_id' => 'required',
            'city_id' => 'required',
            'car_production_year_id' => 'required',
            'car_gos_number' =>  'required',
            'car_hourly_price' => 'required',
        ];

        foreach ($this->services as $service) {
            if (array_key_exists('id', $service))
            {
                foreach ($service['options'] as $key => $item) {
                    $rules['services.'.$service['id'].'.options.'.$key] = 'required';
                }
            }
        }

        return $rules;
    }
}
