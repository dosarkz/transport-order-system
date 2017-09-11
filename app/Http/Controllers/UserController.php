<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\DriverLicense;
use App\Models\DriverService;
use App\Models\Role;
use App\Models\User;
use App\Models\UserDriverLicense;
use App\Models\UserRole;
use Cloudinary\Uploader;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function profile(Request $request)
    {
        $driverLicenses = DriverLicense::all();
        $driverServices = DriverService::all();

        return view('users.profile', compact('driverLicenses','driverServices'));
    }

    public function update(UpdateUserRequest $request)
    {
        $request->merge([
            'birthday' => date('Y-m-d',strtotime($request->input('birthday')))
        ]);

        if($request->has('licenses'))
        {
            UserDriverLicense::where('user_id', $request->user()->id)->delete();

            foreach ($request->input('licenses') as $item) {
                UserDriverLicense::firstOrCreate([
                    'user_id' => $request->user()->id,
                    'driver_license_id' => $item
                ]);
            }
        }


        if($request->hasFile('avatar'))
        {
            \Cloudinary::config(array(
                "cloud_name" => "dzrywvuzd",
                "api_key" => "787332881615333",
                "api_secret" => "j29TCe32La6N8oEV4AyWqc362r8"
            ));

            $uploader = Uploader::upload($request->file('avatar')->getPathName(),['folder' => 'userprofiles']);
            $request->user()->update(['_image_id' => $uploader['public_id']]);
        }

        if($request->has('become_driver'))
        {
            $client_role = UserRole::where('user_id', auth()->user()->id)
                ->where('role_id',Role::where('alias','client')->first()->id )
                ->first();

            if(auth()->user()->user_role_id != $client_role->id)
            {
                $request->merge(['become_driver' => 1]);

                $driver_role = UserRole::firstOrCreate([
                    'user_id' => auth()->user()->id,
                    'role_id' => Role::where('alias','driver')->first()->id
                ]);

                $request->user()->update(['user_role_id' => $driver_role->id]);
            }
        }else{
            $client_role = UserRole::where('user_id', auth()->user()->id)
                ->where('role_id',Role::where('alias','client')->first()->id )
                ->first();

            if(!$client_role)
            {
                $client_role =  UserRole::firstOrCreate(['user_id' =>  auth()->user()->id,
                    'role_id' => Role::where('alias','client')->first()->id]);
            }
            $request->user()->update(['user_role_id' => $client_role->id]);
            $request->merge(['become_driver' =>  0]);
        }

        $request->user()->update($request->all());
        return redirect()->back()->with('success', 'Успешно');

    }


    public function favourites()
    {
        return view('users.favourites');
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $request->user()->update([
            'password' => bcrypt($request->input('password'))
        ]);

        return redirect()->back()->with('success', 'Пароль успешно изменен');
    }

    public function removeAvatar()
    {
        auth()->user()->update([
            '_image_id' => null
        ]);

        return redirect()->back()->with('success', 'Фото удалено');
    }
}
