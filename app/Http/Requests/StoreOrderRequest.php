<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
        $rules = [];

        if($this->type == 'transport')
        {
            $rules['category_id'] = 'required';

        }

        if($this->type == 'service')
        {
            $rules['service_id'] = 'required';
        }

        $rules['client_price'] = 'numeric';

        return $rules;
    }
}
