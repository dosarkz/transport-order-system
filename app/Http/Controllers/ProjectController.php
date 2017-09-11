<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\StoreProjectRequest;
use App\Models\Contractor;
use App\Models\ContractorFileType;
use App\Models\Order;
use App\Models\OrderDriverRequest;
use App\Models\PriceOption;
use App\Models\Project;
use App\Models\ProjectService;
use App\Models\Registry;
use App\Models\Service;
use App\Models\TransportBrand;
use App\Models\TransportCategory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $model = Project::all();
        return view('projects.index',compact('model'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $model = new Project();
        return view('projects.create',compact('model'));
    }

    public function store(StoreProjectRequest $request)
    {
        $request->merge([
            'user_id' => auth()->user()->id,
        ]);

        if($request->has('nds_value'))
        {
            $request->merge([
                'nds_value' => true
            ]);
        }else{
            $request->merge([
                'nds_value' => false
            ]);
        }

        if($request->has('is_nds'))
        {
            $request->merge([
                'is_nds' => true
            ]);
        }else{
            $request->merge([
                'is_nds' => false
            ]);
        }

        Project::create($request->all());
        return redirect('projects')->with('success', 'Проект успешно создан');
    }

    public function edit($id)
    {
        $model = Project::findOrFail($id);
        return view('projects.edit',compact('model'));
    }

    public function update(StoreProjectRequest $request, $id)
    {
        $model = Project::findOrFail($id);

        if($request->has('nds_value'))
        {
            $request->merge([
                'nds_value' => true
            ]);
        }else{
            $request->merge([
                'nds_value' => false
            ]);
        }

        if($request->has('is_nds'))
        {
            $request->merge([
                'is_nds' => true
            ]);
        }else{
            $request->merge([
                'is_nds' => false
            ]);
        }

        $model->update($request->all());

        return redirect()->back()->with('success', 'Проект  успешно обновлен');
    }

    public function show(Request $request, $id)
    {
        $project = Project::findOrFail($id);

        $orders = Order::where('project_id', $project->id)
            ->whereNotIn('status_id', [Order::STATUS_CLIENT_REJECTED, Order::STATUS_CLIENT_COMPLETED])
            ->orderBy('created_at', 'desc');

        if($request->has('date_start'))
        {
            $orders->where('date_start','>', date('Y-m-d',strtotime($request->input('date_start'))));
        }

        if($request->has('date_end'))
        {
            $orders->where('date_end','<', date('Y-m-d',strtotime($request->input('date_end'))));
        }

        if($request->has('order_id'))
        {
            $orders->where('id', $request->input('order_id'));
        }
        if($request->has('contractor_id'))
        {
            $orders->where('contractor_id', $request->input('contractor_id'));
        }
        if($request->has('driver_id'))
        {
            $orders->where('driver_id', $request->input('driver_id'));
        }
        if($request->has('manager_id'))
        {
            $orders->where('user_id', $request->input('manager_id'));
        }
        if($request->has('transport_category_id'))
        {
            $orders->where('car_category_id', $request->input('transport_category_id'));
        }
        if($request->has('transport_brand_id'))
        {
            $orders->where('car_brand_id', $request->input('transport_brand_id'));
        }
        if($request->has('order_service_id'))
        {
            $orders->where('order_service_id', $request->input('order_service_id'));
        }

        if($request->has('status_id'))
        {
          switch ($request->input('status_id'))
          {
              case 'current':
                  $orders->where('date_start', '>=', Carbon::now())
                      ->where('date_start', '<=', Carbon::tomorrow());
                  break;
              case 'finished':
                  $orders->where('status_id', Order::STATUS_CLIENT_COMPLETED);
                  break;
              case 'cancelled':
                  $orders->where('status_id', Order::STATUS_CLIENT_REJECTED);
                  break;
          }
        }

        if($request->has('error'))
        {
            switch ($request->input('error'))
            {
                case 'not_driver':
                    $orders->whereNull('driver_id');
                    break;
                case 'not_auto':
                    $orders->whereNull('car_id');
                    break;
                case 'late_booking':
                    $orders->where('created_at', '>', 'date_start');
                    break;
                case 'not_work_values':
                    $orders->whereHas('registries', function($query){
                        $query->whereNull('value');
                    });
            }
        }

        $orders =  $orders->paginate(20);

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


        return view('projects.show', compact('project', 'orders', 'contractorsList', 'driversList', 'managersList',
            'transport_categories','projectServices'));
    }

    public function destroy($id)
    {
        $model = Project::findOrFail($id);

        $model->orders()->delete();
        $model->registries()->delete();
        $model->services()->delete();
        $model->operators()->delete();

        $model->delete();

        return redirect()->back()->with('success', 'Проект успешно удален');

    }

    /**
     * Create a new order
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createOrder($id)
    {
        $project = Project::findOrFail($id);
        $model = new Order();
        $model->project_id = $project->id;
        $model->date_start = Carbon::now()->timezone('+6');
        $model->date_end = Carbon::now()->addDay()->timezone('+6');

        $transport_categories = TransportCategory::orderBy('name','asc')->pluck('name','id');
        $transport_brands  = [];
        $transport_models = [];
        $contractorsList = Contractor::where('project_id', $project->id)
            ->orderBy('company_name_full', 'asc')
            ->pluck('company_name_full', 'id');

        $contractorDocTypesList = ContractorFileType::pluck('name','id');
        $priceOptionsList = PriceOption::pluck('name', 'id');



        return view('projects.orders.create', compact('project', 'model', 'transport_categories','transport_brands',
            'transport_models','contractorsList','contractorDocTypesList','priceOptionsList'));
    }

    public function printOrders(Request $request, $id)
    {
        $project = Project::findOrFail($id);
        $params = [];

        $orders = Order::where('project_id', $id)
            ->whereNotIn('status_id', [Order::STATUS_CLIENT_REJECTED, Order::STATUS_CLIENT_COMPLETED])
            ->orderBy('created_at', 'desc');

        if($request->has('date_start'))
        {
            $orders->where('date_start','>', date('Y-m-d',strtotime($request->input('date_start'))));
            $params['date_start'] = $request->input('date_start');
        }

        if($request->has('date_end'))
        {
            $orders->where('date_end','<', date('Y-m-d',strtotime($request->input('date_end'))));
            $params['date_end'] = $request->input('date_end');
        }

        if($request->has('order_id'))
        {
            $orders->where('id', $request->input('order_id'));
            $params['order_id'] = $request->input('order_id');
        }
        if($request->has('contractor_id'))
        {
            $orders->where('contractor_id', $request->input('contractor_id'));
            $params['contractor'] = Contractor::findOrFail($request->input('contractor_id'));
        }
        if($request->has('driver_id'))
        {
            $orders->where('driver_id', $request->input('driver_id'));
            $params['driver'] = User::findOrFail($request->input('driver_id'));
        }
        if($request->has('manager_id'))
        {
            $orders->where('user_id', $request->input('manager_id'));
            $params['manager'] = User::findOrFail($request->input('manager_id'));
        }
        if($request->has('transport_category_id'))
        {
            $orders->where('car_category_id', $request->input('transport_category_id'));
            $params['transport_category'] = TransportCategory::findOrFail($request->input('transport_category_id'));
        }
        if($request->has('transport_brand_id'))
        {
            $orders->where('car_brand_id', $request->input('transport_brand_id'));
            $params['transport_brand'] = TransportBrand::findOrFail($request->input('transport_brand_id'));
        }
        if($request->has('order_service_id'))
        {
            $orders->where('order_service_id', $request->input('order_service_id'));
            $params['service'] = ProjectService::findOrFail($request->input('order_service_id'));
        }

        if($request->has('status_id'))
        {
            switch ($request->input('status_id'))
            {
                case 'current':
                    $orders->where('date_start', '>=', Carbon::now())
                        ->where('date_start', '<=', Carbon::tomorrow());
                    $params['status'] = 'Текущие заказы';
                    break;
                case 'finished':
                    $orders->where('status_id', Order::STATUS_CLIENT_COMPLETED);
                    $params['status'] = 'Завершенные заказы';
                    break;
                case 'cancelled':
                    $orders->where('status_id', Order::STATUS_CLIENT_REJECTED);
                    $params['status'] = 'Отмененные заказы';
                    break;
            }
        }

        if($request->has('error'))
        {
            switch ($request->input('error'))
            {
                case 'not_driver':
                    $orders->whereNull('driver_id');
                    break;
                case 'not_auto':
                    $orders->whereNull('car_id');
                    break;
                case 'late_booking':
                    $orders->where('created_at', '>', 'date_start');
                    break;
                case 'not_work_values':
                    $orders->whereHas('registries', function($query){
                        $query->whereNull('value');
                    });
            }
        }

        $orders =  $orders->get();


        return view('projects.prints.orders',compact('orders', 'params', 'project'));
    }

    public function printRegistries($project_id, Request $request)
    {
        $project = Project::findOrFail($project_id);
        $params = [];

        $registries = Registry::where('project_id', $project->id)
            ->orderBy('created_at', 'desc');

        if($request->has('date_start'))
        {
            $registries->where('start_time','>', date('Y-m-d',strtotime($request->input('date_start'))));
            $params['date_start'] = $request->input('date_start');
        }

        if($request->has('date_end'))
        {
            $registries->where('end_time','<', date('Y-m-d',strtotime($request->input('date_end'))));
            $params['date_end'] = $request->input('date_end');
        }

        if($request->has('order_id'))
        {
            $registries->where('order_id', $request->input('order_id'));
            $params['order_id'] = $request->input('order_id');
        }

        if($request->has('contractor_id'))
        {
            $registries->whereHas('order', function($query) use ($request){
                $query->where('contractor_id',  $request->input('contractor_id'));
            });

            $params['contractor'] = Contractor::findOrFail($request->input('contractor_id'));
        }
        if($request->has('driver_id'))
        {
            $registries->whereHas('order', function($query) use ($request){
                $query->where('driver_id',  $request->input('driver_id'));
            });

            $params['driver'] = User::findOrFail($request->input('driver_id'));
        }
        if($request->has('manager_id'))
        {
            $registries->whereHas('order', function($query) use ($request){
                $query->where('user_id',  $request->input('manager_id'));
            });
            $params['manager'] = User::findOrFail($request->input('manager_id'));
        }
        if($request->has('transport_category_id'))
        {
            $registries->whereHas('order', function($query) use ($request){
                $query->where('car_category_id',  $request->input('transport_category_id'));
            });

            $params['transport_category'] = TransportCategory::findOrFail($request->input('transport_category_id'));
        }
        if($request->has('transport_brand_id'))
        {
            $registries->whereHas('order', function($query) use ($request){
                $query->where('car_brand_id',  $request->input('transport_brand_id'));
            });

            $params['transport_brand'] = TransportBrand::findOrFail($request->input('transport_brand_id'));
        }
        if($request->has('order_service_id'))
        {
            $registries->whereHas('order', function($query) use ($request){
                $query->where('order_service_id',  $request->input('order_service_id'));
            });

            $params['service'] = ProjectService::findOrFail($request->input('order_service_id'));
        }

        if($request->has('status_id'))
        {
            switch ($request->input('status_id'))
            {
                case 'current':

                    $registries->where('start_time', '>=', Carbon::now())
                        ->where('start_time', '<=', Carbon::tomorrow());
                    $params['status'] = 'Текущие реестры';
                    break;
                case 'finished':
                    $params['status'] = 'Завершенные реестры';
                    break;
                case 'cancelled':
                    $params['status'] = 'Отмененные реестры';
                    break;
            }
        }


        $models =  $registries->get();

        return view('projects.prints.registries',compact('models', 'params', 'project'));
    }

}
