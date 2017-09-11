<?php
namespace App\Repositories\Notification;

use App\Models\UserDevice;
use Davibennun\LaravelPushNotification\Facades\PushNotification;
use Illuminate\Support\Facades\Log;
use LaravelFCM\Facades\FCM;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;

class Push {

    protected $action;
    protected $platform;
    protected $token;
    protected $data;
    protected $order;
    protected $devices;
    protected $device;
    protected $message;
    protected $description;

    public function __construct($message, $description, $data, $devices)
    {
        $this->message = $message;
        $this->devices = $devices;
        $this->data = $data;
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param mixed $action
     */
    public function setAction($action)
    {
        $this->action = $action;
    }

    /**
     * @return mixed
     */
    public function getPlatform()
    {
        return $this->platform;
    }

    /**
     * @param mixed $platform
     */
    public function setPlatform($platform)
    {
        $this->platform = $platform;
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param mixed $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    public function send()
    {
        return $this->typePlatform();
    }


    public function typePlatform()
    {
        if ($this->devices){

            foreach ($this->devices as $device) {
                $this->device = $device;

                if ($device->push_token)
                {
                    switch(mb_strtolower($device->platform))
                    {
                        case 'android':
                            $this->sendByAndroid();
                            break;
                        case 'ios':
                            $this->sendByIos();
                            break;
                    }
                }
            }
        }

        return true;
    }

    public function sendByAndroid()
    {
//        Log::info('push by device android: '.$this->device);
//
//        $message = PushNotification::Message($this->message,array(
//            'aps' =>[
//                'alert' => [
//                    'title' => 'У вас новое сообщение',
//                    'body'=> 'Описание',
//                ],
//                'content-available' => 1,
//                'badge' => 1,
//                'data' => $this->data
//            ]
//        ));
//
//        PushNotification::app('bakeAndroid')
//            ->to($this->device->push_token)
//            ->send($message);

        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60*20);

        $notificationBuilder = new PayloadNotificationBuilder($this->message);
        $notificationBuilder->setBody($this->data)
            ->setSound('default');

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData(['order' => $this->data]);

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        $downstreamResponse = FCM::sendTo($this->device->push_token, $option, $notification, $data);

        $downstreamResponse->numberSuccess();
        $downstreamResponse->numberFailure();
        $downstreamResponse->numberModification();

        $downstreamResponse->tokensToDelete();
        $downstreamResponse->tokensToModify();
        $downstreamResponse->tokensToRetry();
    }

    public function sendByIos()
    {
        Log::info('push by device ios: '.$this->device);

        PushNotification::app('bakeIOS')
            ->to($this->device->push_token)
            ->send($this->message, [
                'content-available'  => 1,
                'sound' => 'default',
                'custom' => array('custom data' => $this->data)

            ]);
    }

}