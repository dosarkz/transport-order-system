<?php

namespace App\Http\Controllers;


use App\Models\User;

class AdminUserController extends CrudController
{
    protected function setModel()
    {
        return new User();
    }

    protected function modelCondition(&$model)
    {
        if(request()->has('id'))
        {
            $model =  $model->where('id', request()->input('id'));
        }

        if(request()->has('first_name'))
        {
            $first_name = request()->input('first_name');
            $model =  $model->where('first_name','LIKE' ,"%$first_name%");
        }

        if(request()->has('last_name'))
        {
            $last_name = request()->input('last_name');
            $model =  $model->where('last_name','LIKE' ,"%$last_name%");
        }

        if(request()->has('phone'))
        {
            $phone = purify_phone_number(request()->input('phone'));
            $model =  $model->where('phone', request()->input('phone'))->orWhere('phone','LIKE', "%$phone%");
        }
    }

    protected function setViewPath()
    {
        return 'admin.users';
    }

    protected $storeValidationRules = [
        'password' => 'required',

    ];

    public function beforeSave(&$data, $model)
    {
        if(is_null($data['password']))
        {
            unset($data['password']);
        }
    }

}
