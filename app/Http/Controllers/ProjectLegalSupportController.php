<?php

namespace App\Http\Controllers;


use App\Models\Contractor;
use App\Models\ContractorDocument;
use App\Models\Project;
use App\Repositories\File\DocumentFileUploader;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProjectLegalSupportController extends CrudController
{
    protected function setModel()
    {
       return new ContractorDocument();
    }

    protected function setViewPath()
    {
        return 'projects.contractors.legal-supports';
    }

    protected function setModelUrl()
    {
        $project = Project::findOrFail(request()->segment(2));
        $contractor = Contractor::findOrFail(request()->segment(4));

        return 'projects/'.$project->id.'/contractors/'.$contractor->id.'/legal-supports';
    }

    public function create()
    {
        $model = $this->setModel();
        $model->start_at = Carbon::now();
        $model->stop_at = Carbon::tomorrow();

        $params = ['model' => $model, 'url' => $this->setModelUrl(), 'viewPath' => $this->setViewPath()];
        $this->setParams($params);

        return view(sprintf('%s.create', $this->setViewPath()), $params);
    }

    public function modelCondition(&$model)
    {
        $project = Project::findOrFail(request()->segment(2));
        $contractor = Contractor::findOrFail(request()->segment(4));

        $model = $model->where('project_id', $project->id)
            ->where('contractor_id', $contractor->id)
            ->orderBy('created_at', 'asc');
    }

    public function setParams(&$params)
   {
       $params['project'] = Project::findOrFail(request()->segment(2));
       $params['contractor'] = Contractor::findOrFail(request()->segment(4));
   }

    public function edit($id)
    {
        $model = $this->setModel()->find(request()->segment(6));
        if (!$model) {
            return $this->create();
        }

        $params = ['model' => $model, 'url' => $this->setModelUrl(), 'viewPath' => $this->setViewPath()];
        $this->setParams($params);

        return view(sprintf('%s.edit', $this->setViewPath()), $params);
    }

    protected $storeValidationRules = [
        'file_type' => 'required',
        'file_number' => 'required',
        'file_price' => 'required',
        'stop_at' => 'required',
        'start_at' => 'required',
        'file_id' => 'required'
    ];

    public function beforeSave(&$data, $model)
    {
        $data['user_id']  = auth()->user()->id;

        if(request()->hasFile('file_id'))
        {
            $uploader = new DocumentFileUploader(request()->file('file_id'));
            $data['file_id'] = $uploader->model->id;
        }
    }


    public function update(Request $request, $project_id)
    {
        $this->beforeValidate($request);
        $this->validate($request, $this->updateValidationRules);

        $model = $this->setModel()->findOrFail(request()->segment(6));
        $data = $request->except(['_method', '_token']);

        $this->beforeUpdate($data, $model);
        $model->update($data);
        $this->afterUpdate($model);

        return redirect($this->setModelUrl())->with('success','success');
    }

    public function destroy($id)
    {
        $model = $this->setModel()->find(request()->segment(6));
        $this->beforeDestroy($id);
        $model->delete();

        return redirect($this->setModelUrl())->with('success', 'deleted');
    }



}
