<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRegistryRequest;
use App\Http\Requests\UpdateRegistryRequest;
use App\Models\Contractor;
use App\Models\Order;
use App\Models\Project;
use App\Models\Registry;
use App\Models\TransportCategory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Zend\Http\Header\Date;

class ProjectRegistryController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request, $project_id)
    {
        $project = Project::findOrFail($project_id);

        $contractorsList = Contractor::where('project_id', $project->id)
            ->orderBy('company_name_full', 'asc')
            ->pluck('company_name_full', 'id');

        $contractorsList->prepend('Не важно', '');

        $driversList = User::with('transports')->whereHas('orders',function($query) use($project){
            $query->where('project_id', $project->id);
        })
            ->orderBy('first_name', 'asc')
            ->get()
            ->pluck('fullNameWithPhone','id');

        $managersList = User::whereHas('projectOperator', function($query){
            $query->where('post_id', 1);
        })
            ->orderBy('first_name', 'asc')
            ->get()
            ->pluck('fullName','id');

        $transport_categories = TransportCategory::orderBy('name','asc')->pluck('name','id');
        $projectServices = $project->services->pluck('name','id');

        $registries = Registry::where('project_id', $project->id)
            ->orderBy('created_at', 'desc');


        if($request->has('date_start'))
        {
            $registries->where('start_time','>', date('Y-m-d',strtotime($request->input('date_start'))));
        }

        if($request->has('date_end'))
        {
            $registries->where('end_time','<', date('Y-m-d',strtotime($request->input('date_end'))));
        }

        if($request->has('order_id'))
        {
            $registries->where('order_id', $request->input('order_id'));
        }

        if($request->has('contractor_id'))
        {
            $registries->whereHas('order', function($query) use ($request){
                $query->where('contractor_id',  $request->input('contractor_id'));
            });
        }
        if($request->has('driver_id'))
        {
            $registries->whereHas('order', function($query) use ($request){
                $query->where('driver_id',  $request->input('driver_id'));
            });
        }
        if($request->has('manager_id'))
        {
            $registries->whereHas('order', function($query) use ($request){
                $query->where('user_id',  $request->input('manager_id'));
            });
        }
        if($request->has('transport_category_id'))
        {
            $registries->whereHas('order', function($query) use ($request){
                $query->where('car_category_id',  $request->input('transport_category_id'));
            });
        }
        if($request->has('transport_brand_id'))
        {
            $registries->whereHas('order', function($query) use ($request){
                $query->where('car_brand_id',  $request->input('transport_brand_id'));
            });
        }
        if($request->has('order_service_id'))
        {
            $registries->whereHas('order', function($query) use ($request){
                $query->where('order_service_id',  $request->input('order_service_id'));
            });
        }

        if($request->has('status_id'))
        {
            switch ($request->input('status_id'))
            {
                case 'current':

                    $registries->where('start_time', '>=', Carbon::now())
                        ->where('start_time', '<=', Carbon::tomorrow());
                    break;
                case 'finished':

                    break;
                case 'cancelled':

                    break;
            }
        }


        $registries =  $registries->paginate(20);

        return view('projects.registries.index', compact('project', 'registries', 'contractorsList', 'driversList', 'managersList',
            'transport_categories','projectServices'));
    }

    public function create($project_id, Request $request)
    {
        $project = Project::findOrFail($project_id);
        $order = Order::findOrFail($request->input('order_id'));
        $model = new Registry();
        $model->project_id = $project->id;

        return view('projects.registries.create', compact('project', 'order', 'model'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreRegistryRequest $request, $project_id)
    {
        Order::findOrFail($request->input('order_id'));

        $request->merge([
            'project_id' => $project_id,
            'start_time' => date('Y-m-d H:i:s', strtotime($request->input('start_time'))),
            'end_time' => date('Y-m-d H:i:s', strtotime($request->input('end_time'))),
        ]);

        Registry::create($request->only(['start_time', 'end_time', 'order_id', 'start_point','end_point', 'project_id']));

        return redirect(sprintf('/projects/%s/registries', $project_id))->with('success','Реестр создан');
    }


    public function edit($project_id, $registry_id)
    {
        $model = Registry::findOrFail($registry_id);
        return view('projects.registries.edit', compact('model'));
    }

    /**
     * @param $project_id
     * @param $order_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRegistryRequest $request, $project_id, $registry_id)
    {
        $model =  Registry::findOrFail($registry_id);

        $start_time = Carbon::parse($model->start_time)->setTime(
            date('H', strtotime($request->input('start_time')) ),
            date('i', strtotime($request->input('start_time')))
        );

        $end_time = Carbon::parse($model->end_time)->setTime(
            date('H', strtotime($request->input('end_time')) ),
            date('i', strtotime($request->input('end_time')))
        );

        $request->merge([
            'start_time' => $start_time,
            'end_time' => $end_time
        ]);

        $model->update($request->all());

        return redirect(sprintf('/projects/%s/registries', $project_id))->with('success','Реестр обновлен');

    }

    /**
     * @param $project_id
     * @param $order_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($project_id, $order_id)
    {

    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($project_id, $registry_id)
    {
        $model = Registry::findOrFail($registry_id);
        $model->delete();
        return redirect()->back()->with('success','Успешно удален');
    }

    public function complete($project_id, $registry_id, Request $request)
    {
        $model = Registry::findOrFail($registry_id);

        $model->status_id = Registry::STATUS_COMPLETE;
        $model->save();

        return redirect()->back()->with('success','Регистр успешно закрыт');
    }



}
