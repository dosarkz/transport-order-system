<?php

namespace App\Listeners;

use App\Events\OrderCreatedEvent;
use App\Models\User;
use App\Models\UserDevice;
use App\Repositories\Notification\Push;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class OrderPushEventListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     * @param OrderCreatedEvent $event
     */
    public function handle(OrderCreatedEvent $event)
    {

        if($event->order->car_id)
        {
            $data = [
                'id' => $event->order->id,
                'type' =>'Orders.Add.Driver',
                'text' => 'Вам поступил новый заказ'
            ];

            $push = new Push('Новый заказ #'.$event->order->id.' | Unipark', 'Описание',
                $data, $event->order->transport->driver->userDevices);
            $push->send();

        }else{
            $data = [
                'id' => $event->order->id,
                'type' =>'Orders.Add',
                'text' => 'Проверьте свободные заказы'
            ];



            if($event->order->car_category_id)
            {
                $users =   User::whereHas('transports', function ($query) use ($event){
                    $query->where('car_category_id', $event->order->car_category_id);
                })->select('id')->pluck('id');


                $devices = UserDevice::whereIn('user_id',$users)->get();
                $push = new Push('Новый заказ #'.$event->order->id.' | Unipark', 'Описание',
                    $data, $devices);

                $push->send();
            }

            if($event->order->service_id)
            {
                $users =   User::whereHas('transports', function ($query) use ($event){
                    $query->whereHas('transportServices', function ($queryService) use ($event){
                       $queryService->where('service_id',  $event->order->service_id);
                    });
                })->select('id')->pluck('id');

                $devices = UserDevice::whereIn('user_id',$users)->get();

                $push = new Push('Новый заказ #'.$event->order->id.' | Unipark', 'Описание',
                    $data, $devices);

                $push->send();
            }
        }
    }
}
