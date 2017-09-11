<?php
namespace App\Repositories;

class SmsManager
{
    private static $instance = null;

    private $login;
    private $password;

    private $lastMessageError = '';

    private function __construct()
    {
        $this->login = env('SMS_CHANNEL_LOGIN');
        $this->password = env('SMS_CHANNEL_PASSWORD');
    }

    private function __clone()
    {   }

    public static function getInstance()
    {
        if(self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * @param array|string $phones
     * @param string $message
     * @return bool
     */
    public function sendSms($phones, $message)
    {
        $postData = [
            'login' => $this->login,
            'psw' => $this->password,
            'phones' => $this->handlePhoneNumbers($phones),
            'mes' => $message,
            'sender' => 'Unipark',
            'fmt' => 3,
            'charset' => 'utf-8'
        ];
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL,"https://smsc.kz/sys/send.php");
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($postData));
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($curl, CURLOPT_TIMEOUT, 60);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curl);

        curl_close ($curl);

        $response = json_decode($response, true);
        if(isset($response['id']) && isset($response['cnt'])) {
            return true;
        }
        $this->lastMessageError = isset($response['error']) ? $response['error'] : 'Неизвестная ошибка';
        return false;
    }

    private function handlePhoneNumbers($phones)
    {
        if(is_array($phones)) {
            foreach ($phones as &$phone) {
                $phone = purify_phone_number($phone);
            }
            $phones = implode(',', $phones);
        } else {
            $phones = purify_phone_number($phones);
        }
        return $phones;
    }

    public function getError()
    {
        return $this->lastMessageError;
    }

}
