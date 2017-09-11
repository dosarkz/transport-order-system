<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PickUpOrderRequest extends FormRequest
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
        return [
            'order_id' => 'required|numeric',
            'driver_price' => 'required|numeric',
            'car_id' => 'required',
        ];
    }
}
