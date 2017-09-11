<?php

namespace App\Http\Controllers;


use App\Models\Contractor;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectContractorController extends CrudController
{
    protected function setModel()
    {
       return new Contractor();
    }

    protected function setViewPath()
    {
        return 'projects.contractors';
    }

    protected function setModelUrl()
    {
        return 'projects/'.request()->segment(2).'/contractors';
    }

    public function modelCondition(&$model)
    {
        $project = Project::findOrFail(request()->segment(2));

        if(request()->has('company_name_full'))
        {
            $company_name_full = request()->input('company_name_full');
            $model = $model->where('company_name_full','LIKE', "%$company_name_full%");
        }

        if(request()->has('bin'))
        {
            $bin = request()->input('bin');
            $model = $model->where('bin','LIKE', "%$bin%");
        }

        if(request()->has('phone'))
        {
            $phone = request()->input('phone');
            $model = $model->where('phone','LIKE', "%$phone%");
        }

        if(request()->has('fact_address'))
        {
            $fact_address = request()->input('fact_address');
            $model = $model->where('fact_address','LIKE', "%$fact_address%");
        }

        $model = $model->where('project_id', $project->id)->orderBy('company_name_full', 'asc');
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
        'company_name_full' => 'required',
        'bin' => 'required'

    ];

    public function beforeSave(&$data, $model)
    {
        $data['user_id']  = auth()->user()->id;

        if(request()->has('nds_value'))
        {
            $data['nds_value'] =  true;
        }else{
            $data['nds_value'] =  false;
        }

        if(request()->has('is_nds'))
        {
            $data['is_nds'] =  true;
        }else{
            $data['is_nds'] =  false;
        }
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
