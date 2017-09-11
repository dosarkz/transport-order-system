<?php

namespace App\Http\Controllers;

use App\Http\Requests\PickUpOrderRequest;
use App\Models\Order;
use App\Models\OrderDriverRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DriverOrdersController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::where('status_id', Order::STATUS_IN_PROCESSING)
            ->orderBy('id', 'desc')
            ->paginate(20);

        return view('driver.orders.index', compact('model', 'service', 'orders'));
    }

    public function store(Request $request)
    {
        $data = $request->all();

        if($request->has('category_id'))
        {
            $data['service_id'] = $request->input('category_id');
        }

        if($request->has('service_id'))
        {
            $data['service_id'] = $request->input('service_id');
        }

        $data['date_start'] = Carbon::now();
        $data['user_id'] = auth()->user()->id;
        $data['status_id'] = 0;

        $order = Order::create($data);

        return redirect()->back()->with('success', sprintf('Заказ #%s успешно создан', $order->id));
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->back()->with('success','Успешно');

    }
    public function pickUpTheOrder(PickUpOrderRequest $request)
    {
        $order = Order::findOrFail($request->input('order_id'));

        OrderDriverRequest::firstOrCreate([
          'order_id' => $order->id,
          'user_id' => auth()->user()->id,
         'car_id' => $request->input('car_id'),
         'price' => $request->input('driver_price'),
        ]);

        return redirect()->back()->with('success', 'Ваша заявка отправлена');

    }

    public function cancelRequest($order_id, $request_id){
        $order = Order::findOrFail($order_id);
        $orderRequest = OrderDriverRequest::findOrFail($request_id);
        $orderRequest->delete();

        return redirect()->back()->with('success', 'Ваша заявка отменена');

    }
}
