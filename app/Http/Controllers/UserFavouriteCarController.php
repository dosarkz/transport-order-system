<?php

namespace App\Http\Controllers;

use App\Models\Transport;
use App\Models\UserFavouriteCar;
use Illuminate\Http\Request;

class UserFavouriteCarController extends CrudController
{
    protected function setModel()
    {
        return new UserFavouriteCar();
    }

    protected function modelCondition(&$model)
    {

    }

    public $afterSaveRedirectUrl = '/transports';


    public function index()
    {
        $model = Transport::whereHas('userFavourites', function($query)
        {
            $query->where('user_id', auth()->user()->id);
        });

        $params = ['models' => $model->paginate(15), 'url' => $this->setModelUrl()];
        $this->setParams($params);

        return view(sprintf('%s.index', $this->setViewPath()), $params);
    }


    public function store(Request $request)
    {
        $this->beforeValidate($request);
        $this->validate($request, $this->storeValidationRules);

        $data = $request->only('transport_id');
        $model = $this->setModel();
        $this->beforeSave($data, $model);
        $created_model = $model->firstOrCreate($data);
        $this->afterSave($created_model);

        return redirect()->back()->with('success','success');
    }

    protected function setViewPath()
    {
        return 'favourites';
    }

    protected $storeValidationRules = [
        'transport_id' => 'required',
    ];

    public function beforeSave(&$data, $model)
    {
        $data['user_id'] = auth()->user()->id;
    }

    public function destroy($id)
    {
        $model = $this->setModel()->find($id);
        $this->beforeDestroy($id);
        $model->delete();

        return redirect()->back()->with('success','deleted');
    }
}
