<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\CrudInterface;
use Illuminate\Http\Request;


abstract class CrudController extends Controller
{
    /**
     * @var string path to view folder
     */

    abstract protected function setViewPath();


    protected function setModelUrl()
    {
        return 'admin/'.request()->segment(2);
    }

    /**
     * @var string default = $modelUrl
     */
    protected $afterSaveRedirectUrl = '';

    public $id;

    /**
     * @var string full class name, example '\App\Models\Category'
     */
    abstract protected function setModel();

    /**
     * @var array rules for Validator to store modelClass object
     */
    protected $storeValidationRules = [];

    /**
     * @var array rules for Validator to update modelClass object
     */
    protected $updateValidationRules = [];

    /**
     * @var array list of disabled actions
     */
    protected $disabledActions = [];

    public function __construct()
    {
        if($this->afterSaveRedirectUrl == '') {
            $this->afterSaveRedirectUrl = $this->setModelUrl();
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->checkForDisabled(__FUNCTION__);
        $model = $this->setModel();
        $this->modelCondition($model);

        $params = ['models' => $model->paginate(15), 'url' => $this->setModelUrl()];
        $this->setParams($params);

        return view(sprintf('%s.index', $this->setViewPath()), $params);
    }

    public function setParams(&$params)
    {

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->checkForDisabled(__FUNCTION__);
        $model = $this->setModel();
        $params = ['model' => $model, 'url' => $this->setModelUrl(), 'viewPath' => $this->setViewPath()];
        $this->setParams($params);

        return view(sprintf('%s.create', $this->setViewPath()), $params);
    }

    /**
     * @description invoked before saving new model
     * @param $data Request data
     */
    abstract protected function beforeSave(&$data, $model);

    /**
     * @param Request $request
     */
    protected function beforeValidate(Request $request)
    {   }

    /**
     * @param $model
     */
    protected function modelCondition(&$model)
    {   }

    protected function afterSave($model)
    {    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->checkForDisabled(__FUNCTION__);
        $this->beforeValidate($request);
        $this->validate($request, $this->storeValidationRules);

        $data = $request->all();
        $model = $this->setModel();
        $this->beforeSave($data, $model);
        $created_model = $model->create($data);
        $this->afterSave($created_model);

        return redirect($this->afterSaveRedirectUrl)->with('success','success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->checkForDisabled(__FUNCTION__);
        $model = $this->setModel()->find($id);

        return view(sprintf('%s.show', $this->setViewPath()), ['model' => $model, 'url' => $this->setModelUrl(), 'viewPath' => $this->setViewPath()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->checkForDisabled(__FUNCTION__);
        $model = $this->setModel()->find($id);
        if (!$model) {
            return $this->create();
        }
        return view(sprintf('%s.edit', $this->setViewPath()), ['model' => $model, 'url' => $this->setModelUrl(), 'viewPath' => $this->setViewPath()]);
    }

    /**
     * @description invoked before updating new model
     * @param $data Request data
     */
    protected function beforeUpdate(&$data, $model)
    {
        $this->beforeSave($data, $model);
    }

    protected function afterUpdate($model)
    {
        $this->afterSave($model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->checkForDisabled(__FUNCTION__);
        $this->beforeValidate($request);
        $this->validate($request, $this->updateValidationRules);

        $model = $this->setModel()->findOrFail($id);
        $data = $request->except(['_method', '_token']);

        $this->beforeUpdate($data, $model);
        $model->update($data);
        $this->afterUpdate($model);

        return redirect($this->setModelUrl())->with('success','success');
    }

    protected function setId()
    {

    }

    protected function beforeDestroy($id)
    {   }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->checkForDisabled(__FUNCTION__);
        $model = $this->setModel()->find($id);
        $this->beforeDestroy($id);
        $model->delete();

        return redirect($this->setModelUrl())->with('success', 'deleted');
    }

    public function delete($id)
    {
        $this->checkForDisabled(__FUNCTION__);
        $model = $this->setModel()->find($id);
        return view(sprintf('%s.delete', $this->setViewPath()), ['model' => $model, 'url' => $this->setModelUrl(), 'viewPath' => $this->setViewPath()]);
    }

    private function checkForDisabled($functionName)
    {
        if(in_array($functionName, $this->disabledActions)) {
            abort(404);
        }
    }

}
