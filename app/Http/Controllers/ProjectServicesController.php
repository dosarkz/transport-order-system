<?php

namespace App\Http\Controllers;


use App\Models\Contractor;
use App\Models\Project;
use App\Models\ProjectService;
use Illuminate\Http\Request;

class ProjectServicesController extends CrudController
{
    protected function setModel()
    {
       return new ProjectService();
    }

    protected function setViewPath()
    {
        return 'projects.services';
    }

    protected function setModelUrl()
    {
        return 'projects/'.request()->segment(2).'/services';
    }

    public function modelCondition(&$model)
    {
        $project = Project::findOrFail(request()->segment(2));
        $model = $model->where('project_id', $project->id)->orderBy('created_at', 'asc');
    }

    public function setParams(&$params)
   {
       $params['project'] = Project::findOrFail(request()->segment(2));
   }

    public function edit($id)
    {
        $model = $this->setModel()->find(request()->segment(4));
        if (!$model) {
            return $this->create();
        }
        return view(sprintf('%s.edit', $this->setViewPath()), [
            'model' => $model, 'url' => $this->setModelUrl(),
            'project' => Project::findOrFail(request()->segment(2)),
            'viewPath' => $this->setViewPath()
        ]);
    }

    protected $storeValidationRules = [
        'name' => 'required',
        'project_id' => 'required'

    ];

    public function beforeSave(&$data, $model)
    {

    }

    public function update(Request $request, $project_id)
    {
        $this->beforeValidate($request);
        $this->validate($request, $this->updateValidationRules);

        $model = $this->setModel()->findOrFail(request()->segment(4));
        $data = $request->except(['_method', '_token']);

        $this->beforeUpdate($data, $model);
        $model->update($data);
        $this->afterUpdate($model);

        return redirect($this->setModelUrl())->with('success','success');
    }

    public function destroy($id)
    {
        $model = $this->setModel()->find(request()->segment(4));
        $this->beforeDestroy($id);
        $model->delete();

        return redirect($this->setModelUrl())->with('success', 'deleted');
    }

}
