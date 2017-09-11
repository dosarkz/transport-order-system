<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectAccountRequest;
use App\Models\Project;
use App\Models\ProjectOperator;
use App\Models\Role;
use App\Models\UserRole;
use Illuminate\Http\Request;

class ProjectAccountController extends Controller
{

    public function index(Request $request, $project_id)
    {
        $project = Project::findOrFail($project_id);
        $accounts = ProjectOperator::where('project_id', $project->id)->get();

        return view('projects.accounts.index', compact('project','accounts'));
    }

    public function create($project_id)
    {
        $project = Project::findOrFail($project_id);
        $model = new ProjectOperator();

        return view('projects.accounts.create', compact('model', 'project'));
    }

    /**
     * @param StoreProjectAccountRequest $request
     * @param $project_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreProjectAccountRequest $request, $project_id)
    {
       $operator =  ProjectOperator::firstOrCreate([
            'project_id' => $project_id,
            'user_id' => $request->input('user_id'),
        ]);

        $operator->update([
            'post_id' => $request->input('post_id')
        ]);

        UserRole::firstOrCreate([
            'user_id' => $operator->user_id,
            'role_id' => Role::ROLE_OPERATOR
        ]);

        return redirect('/projects/'.$project_id.'/accounts')->with('success', sprintf('Оператов #%s успешно добавлен', $operator->id));
    }


    public function edit($project_id, $order_id)
    {

    }


    public function update(StoreProductOrderRequest $request, $project_id, $order_id)
    {

    }

    public function show($project_id, $order_id)
    {

    }

    public function destroy($project_id, $operator_id)
    {
        $projectOperator = ProjectOperator::findOrFail($operator_id);

        UserRole::where([
            'user_id' => $projectOperator->user_id,
            'role_id' => Role::ROLE_OPERATOR
        ])->delete();

        $projectOperator->delete();

        return redirect()->back()->with('success','Успешно');

    }

}
