<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\StoreProductOrderRequest;
use App\Models\Contractor;
use App\Models\ContractorFileType;
use App\Models\Order;
use App\Models\OrderContractorPhone;
use App\Models\OrderDriverNotification;
use App\Models\OrderDriverRequest;
use App\Models\OrderTransport;
use App\Models\PriceOption;
use App\Models\Project;
use App\Models\Registry;
use App\Models\Transport;
use App\Models\TransportCategory;
use App\Repositories\Notification\Push;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProjectOrderController extends Controller
{

    public function create($project_id, Request $request)
    {
        $project = Project::findOrFail($project_id);

        if($request->has('order_id'))
        {
            $model = Order::findOrFail($request->input('order_id'));
        }else{
            $model = new Order();
        }

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

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $orders = Order::where('user_id', auth()->user()->id)
            ->orderBy('id', 'desc')
            ->get();
        $transport_categories = TransportCategory::orderBy('name','asc')->pluck('name','id');

        return view('orders.index', compact('model', 'service', 'orders', 'transport_categories'));
    }

    /**
     * @param StoreProductOrderRequest $request
     * @param $project_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreProductOrderRequest $request, $project_id)
    {
        $data = $request->all();

        $data['date_start'] = date('Y-m-d H:i:s', strtotime($request->input('date_start')));
        $data['date_end'] = date('Y-m-d H:i:s', strtotime($request->input('date_end')));
        $data['project_id'] = $project_id;
        $data['user_id'] = auth()->user()->id;
        $data['status_id'] = Order::STATUS_DRIVER_SELECTED;

        $transport = Transport::findOrFail($request->input('car_id'));
        if($transport)
        {
            $data['driver_id'] = $transport->car_driver_id;
        }

        $order = Order::create($data);

        $dataPush = [
            'id' => $order->id,
            'type' =>'Orders.Add.Driver',
            'text' => 'Вам поступил новый заказ'
        ];

        $push = new Push('Новый заказ #'.$order->id.' | Unipark', 'Описание',
            $dataPush, $transport->driver->userDevices);
        $push->send();

        if(isset($data['phones']))
        {
            foreach ($data['phones'] as $phone) {
                OrderContractorPhone::create([
                    'order_id' => $order->id,
                    'phone' => (int)purify_phone_number($phone),
                    'contractor_id' => isset($order->contractor_id) ? $order->contractor_id : null,
                    'project_id' => $project_id,
                ]);
            }
        }

        $timeCurrentStart = strtotime($data['date_start']);
        $timeStopAt = strtotime($data['date_end']);
        $timeIterationCurrentStart = strtotime($data['date_start']);
        $timeIterationStopAt = strtotime($data['date_end']);

        $countDays = [];
        $iterations = 0;

        while ($timeIterationCurrentStart <= $timeIterationStopAt) {
            $timeIterationCurrentStart = strtotime(" + 1 day", $timeIterationCurrentStart);
            $iterations++;
        }

        $i = 1;

        while ($timeCurrentStart <= $timeStopAt) {

            $start_time_iteration = Carbon::createFromTimestamp($timeCurrentStart);
            $end_time_iteration = Carbon::createFromTimestamp($timeCurrentStart)->setTime(
                12,00);

            if($i > 1)
            {
                $start_time_iteration = Carbon::createFromTimestamp($timeCurrentStart)->setTime(
                    00,00);
                $end_time_iteration = Carbon::createFromTimestamp($timeCurrentStart)->setTime(
                    12,00);
            }

            if($i == $iterations)
            {
                if($i == 1)
                {
                    $start_time_iteration = Carbon::createFromTimestamp($timeCurrentStart);
                }else{
                    $start_time_iteration = Carbon::createFromTimestamp($timeCurrentStart)->setTime(
                        00,00);
                }

                $end_time_iteration = Carbon::createFromTimestamp($timeStopAt);
            }

            $countDays[] = [
                'timeCurrentStart' => $start_time_iteration,
                'timeCurrentEnd'=> $end_time_iteration
            ];

            $timeCurrentStart = strtotime(" + 1 day", $timeCurrentStart);
            $i++;
        }


        foreach ($countDays as $item) {
            Registry::create([
                'start_time' => $item['timeCurrentStart'],
                'end_time' => $item['timeCurrentEnd'],
                'order_id' => $order->id,
                'project_id' => $project_id,
                'tariff_id' => $data['tariff_id'],
                'start_point' => $data['start_point_text'],
                'end_point' => $data['end_point_text'],
                'user_id' => auth()->user()->id
            ]);
        }

        return redirect('/projects/'.$project_id)->with('success', sprintf('Заказ #%s успешно создан', $order->id));
    }


    public function edit($project_id, $order_id)
    {
        $project = Project::findOrFail($project_id);
        $model = Order::findOrFail($order_id);
        $model->project_id = $project->id;

        $transport_categories = TransportCategory::orderBy('name','asc')->pluck('name','id');
        $transport_brands  = [];
        $transport_models = [];
        $contractorsList = Contractor::where('project_id', $project->id)
            ->orderBy('company_name_full', 'asc')
            ->pluck('company_name_full', 'id');

        $contractorDocTypesList = ContractorFileType::pluck('name','id');
        $priceOptionsList = PriceOption::pluck('name', 'id');

        return view('projects.orders.edit', compact('project', 'model', 'transport_categories','transport_brands',
            'transport_models','contractorsList','contractorDocTypesList','priceOptionsList'));
    }

    /**
     * @param StoreProductOrderRequest $request
     * @param $project_id
     * @param $order_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(StoreProductOrderRequest $request, $project_id, $order_id)
    {
        $data = $request->all();

        $data['date_start'] = date('Y-m-d H:i:s', strtotime($request->input('date_start')));
        $data['date_end'] = date('Y-m-d H:i:s', strtotime($request->input('date_end')));
        $data['project_id'] = $project_id;
        $data['user_id'] = auth()->user()->id;

        $order = Order::findOrFail($order_id);

        $transport = Transport::findOrFail($request->input('car_id'));
        if($transport)
        {
            $data['driver_id'] = $transport->car_driver_id;
        }


        $order->update($data);

        if(isset($data['phones']))
        {
            foreach ($data['phones'] as $phone) {
                if($phone)
                {
                    OrderContractorPhone::firstOrCreate([
                        'order_id' => $order->id,
                        'phone' => purify_phone_number($phone),
                        'contractor_id' => $order->contractor_id,
                        'project_id' => $project_id,
                    ]);
                }

            }
        }

        $timeCurrentStart = strtotime($data['date_start']);
        $timeStopAt = strtotime($data['date_end']);

        if($timeCurrentStart != strtotime($order->date_start) && $timeStopAt != strtotime($order->date_end))
        {
            while ($timeCurrentStart <= $timeStopAt) {
                Registry::firstOrCreate([
                    'start_time' => date('Y-m-d H:i:s', $timeCurrentStart),
                    'end_time' => date('Y-m-d H:i:s', $timeCurrentStart),
                    'order_id' => $order->id,
                    'project_id' => $project_id,
                    'tariff_id' => $data['tariff_id'],
                    'start_point' => $data['start_point_text'],
                    'end_point' => $data['end_point_text'],
                    'user_id' => auth()->user()->id
                ]);

                $timeCurrentStart = strtotime(" + 1 day", $timeCurrentStart);
            }
        }



        return redirect('/projects/'.$project_id)->with('success', sprintf('Заказ #%s успешно обновлен', $order->id));
    }

    /**
     * @param $project_id
     * @param $order_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($project_id, $order_id)
    {
        $order = Order::findOrFail($order_id);
        $project = Project::findOrFail($project_id);

        return view('projects.orders.show', compact('order', 'project'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($project_id, $order_id)
    {
        $order = Order::findOrFail($order_id);
        $order->registries()->delete();
        $order->delete();
        return redirect()->back()->with('success','Успешно удален');
    }

    public function driverRequests($project_id, $order_id)
    {
        $order = Order::findOrFail($order_id);
        $project = Project::findOrFail($project_id);


        return view('projects.orders.driver_request', compact('order', 'project'));
    }

    public function cancel($project_id, $order_id)
    {
        $order = Order::findOrFail($order_id);
        $order->status_id = Order::STATUS_CLIENT_REJECTED;
        $order->save();

        return redirect('/projects/'.$project_id)->with('success', sprintf('Заказ #%s успешно отменен', $order->id));
    }

    public function printOrder($project_id, $order_id)
    {
        $model = Order::findOrFail($order_id);
        return view('projects.prints.order', compact('model'));
    }

    public function comment($project_id, $order_id, Request $request)
    {
        $model = Order::findOrFail($order_id);
        $model->description = $request->input('description');
        $model->save();
        return redirect()->back()->with('success', sprintf('Комментарии на заказ#%s отправлен', $model->id));
    }

}
