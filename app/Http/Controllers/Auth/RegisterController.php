<?php

namespace App\Http\Controllers\Auth;

use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use App\Models\UserSms;
use App\Repositories\SmsManager;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'phone_number' => 'required',
        ]);
    }

    protected function confirmSmsValidator(array $data)
    {
        return Validator::make($data, [
            'code' => 'required|numeric',
        ]);
    }


    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        $phone = purify_phone_number($request->input('phone_number'));

        $code = rand(1000,9999);
        $user_sms = UserSms::where('phone_number', substr($phone, 1, 10))->first();

        if ($user_sms)
        {
            $user_sms->code = $code;
            $user_sms->status_id = false;
            $user_sms->update();
        }else{
            UserSms::create([
                'phone_number' => substr($phone, 1, 10),
                'code' => $code
            ]);
        }

        $smsManager = SmsManager::getInstance();
        $smsManager->sendSms($phone, sprintf('Ваш код для сервиса UNIPARK: %s',
            $code
        ));

        return redirect('register/confirm-sms?phone='.$phone)->with('success', 'Пожалуйста, не покидайте страницу. Ожидайте СМС на указанный вами номер телефона.Как только получите, введите и нажмите кнопку "Проверить код"');
    }


    public function showConfirmSmsForm()
    {
        return view('auth.confirm_sms');
    }

    public function confirmSms(Request $request)
    {
        $this->confirmSmsValidator($request->all())->validate();
        $phone = substr(purify_phone_number($request->input('phone')), 1, 10);

        $user_sms = UserSms::where('code', $request->input('code'))
                            ->where('phone_number', $phone)
                            ->where('status_id', false)->first();

        if($user_sms)
        {
            event(new Registered($user = $this->create($request->all())));
            $this->guard()->login($user);
            return redirect('/');

        }else{
            return redirect()->back()->with('error', 'Код подтверждения неверен.');
        }


    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $password = rand(1111,9999);
        $phone =  substr(purify_phone_number($data['phone']), 1, 10);

        $user = User::where('phone', $phone)->first();

        if(!$user)
        {
            $user =  User::firstOrCreate([
                'phone' => $data['phone'],
                'password' => bcrypt($password)
            ]);

            $role = Role::where('alias', 'client')->first();

            $user_role = UserRole::firstOrCreate([
                'role_id' => $role->id,
                'user_id' => $user->id,
            ]);

            $user->update([
                'user_role_id' => $user_role->id,
            ]);
        }

        return $user;
    }
}
