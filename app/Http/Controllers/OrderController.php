<?php

namespace App\Http\Controllers;

use App\Events\OrderCreatedEvent;
use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;
use App\Models\OrderDriverRequest;
use App\Models\TransportCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::where('user_id', auth()->user()->id)
            ->orderBy('id', 'desc')
            ->whereNotIn('status_id',[Order::STATUS_CLIENT_REJECTED, Order::STATUS_DRIVER_REJECTED])
            ->whereNull('project_id')
            ->get();
        $transport_categories = TransportCategory::orderBy('name','asc')->pluck('name','id');

        return view('orders.index', compact('model', 'service', 'orders', 'transport_categories'));
    }

    public function store(StoreOrderRequest $request)
    {
        $data = $request->all();

        if($request->has('category_id'))
        {
            $data['car_category_id'] = $request->input('category_id');
        }

        if($request->has('service_id'))
        {
            $data['service_id'] = $request->input('service_id');
        }

        $data['date_start'] = Carbon::now();
        $data['user_id'] = auth()->user()->id;
        $data['status_id'] = $request->input('status_id');

        $order = Order::create($data);

        event(new OrderCreatedEvent($order));

        return redirect()->back()->with('success', sprintf('Заказ #%s успешно создан', $order->id));
    }

    public function update(StoreOrderRequest $request, $id)
    {
        $order = Order::findOrFail($id);
        $request->merge([
            'date_start' => date('Y-m-d h:i:s', strtotime($request->input('date_start'))),
        ]);
        $order->update($request->all());

        return redirect()->back()->with('success', sprintf('Заказ #%s успешно обновлен', $order->id));
    }

    public function show($id)
    {
        $model = Order::findOrFail($id);
        return view('orders.show', compact('model'));
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->back()->with('success','Успешно');

    }

    public function cancelADriver($id)
    {
        $order = Order::findOrFail($id);
        $order->car_id = null;
        $order->status_id = Order::STATUS_CLIENT_REJECTED;
        $order->save();

        return redirect()->back()->with('success', 'Водитель отменен');
    }

    public function confirmADriverRequest($order_id, $request_id)
    {
        $orderDriverRequest = OrderDriverRequest::findOrFail($request_id);
        $order = Order::findOrFail($order_id);

        $order->status_id = Order::STATUS_DRIVER_SELECTED;
        $order->car_id = $orderDriverRequest->car_id;
        $order->car_category_id = $orderDriverRequest->transport->transportCategory->id;
        $order->car_brand_id = $orderDriverRequest->transport->transportBrand->id;
        $order->driver_id = $orderDriverRequest->user_id;
        $order->driver_price = $orderDriverRequest->price;
        $order->save();

        return redirect()->back()->with('success', 'Водитель подтвержден');
    }
}
