<?php

use Illuminate\Database\Seeder;

class ParseUsersSeeder extends ParseSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */


    public function run()
    {
        DB::table('services')->truncate();
        DB::table('services')->delete();

        $services = $this->parse('services.json');

        if ($services)
        {
            foreach ($services as $item) {
                \App\Models\Service::create([
                    'id' => $item->_id,
                    'name' => $item->name,
                    '_image_id' => $item->image,
                    'position' => $item->position,
                ]);
            }
        }

        DB::table('users')->truncate();
        DB::table('users')->delete();

        DB::table('user_roles')->truncate();
        DB::table('user_roles')->delete();

        DB::table('user_devices')->truncate();
        DB::table('user_devices')->delete();

        DB::table('user_driver_licenses')->truncate();
        DB::table('user_driver_licenses')->delete();

        DB::table('user_driver_services')->truncate();
        DB::table('user_driver_services')->delete();

        $users = $this->parse('users.json');

        if ($users)
        {
            foreach ($users as $item) {

                if(isset($item->username))
                {
                    $has_user =  \App\Models\User::where([
                        ['phone','=',$item->username],
                        ['first_name', '=', isset($item->profile->firstName) ? $item->profile->firstName : null],
                        ['last_name','=', isset($item->profile->lastName)  ? $item->profile->lastName : null]
                    ])->first();

                    if($has_user){
                        continue;
                    }

                    $user  =  \App\Models\User::create([
                        'first_name' => isset($item->profile->firstName) ? $item->profile->firstName : null,
                        'last_name' => isset($item->profile->lastName)  ? $item->profile->lastName : null,
                        'phone' =>  isset($item->username) ? $item->username : null,
                        'company' => isset($item->profile->company) ? $item->profile->company : null,
                        'birthday' => isset($item->profile->bdate) ? date('Y-m-d', (int)$item->profile->bdate) : null,
                        'password' => bcrypt('123456'),
                        'gender' =>  isset($item->profile->pol) ? $item->profile->pol : null,
                        'city_id' =>  isset($item->profile->cityId) ? $item->profile->cityId != '' ? $item->profile->cityId : null : null,
                        'latitude' => isset($item->location)  ?  $item->location->lat : null,
                        'longitude' => isset($item->location)  ?  $item->location->lng : null,
                        'location_updated_at' => isset($item->location)  ? $item->location->lastUpdated  : null,
                        'email' => isset($item->profile->email) ? $item->profile->email : null,
                        'driver_about' => isset($item->driver) ? $item->driver->aboutText : null,
                        '_id' => $item->_id,
                        '_image_id' => isset($item->profile->imageId) ? $item->profile->imageId : null
                    ]);

                    if(isset($item->roles))
                    {
                            foreach ($item->roles as $role) {
                                $role  = \App\Models\Role::where('alias', $role)->first();
                                if($role)
                                {
                                    \App\Models\UserRole::create([
                                        'user_id' => $user->id,
                                        'role_id' => $role->id,
                                    ]);
                                }

                            }
                    }


                    if(isset($item->profile->driver))
                    {

                        if(isset($item->profile->driver->services))
                        {
                            foreach ($item->profile->driver->services as $service) {
                                \App\Models\UserDriverService::create([
                                    'user_id' => $user->id,
                                    'driver_service_id' =>  $service
                                ]);
                            }

                        }

                        if(isset($item->profile->driver->licenses))
                        {
                            foreach ($item->profile->driver->licenses as $license) {
                                \App\Models\UserDriverLicense::create([
                                    'user_id' => $user->id,
                                    'driver_license_id' =>  $license
                                ]);
                            }
                        }
                    }

                    if(isset($item->profile->androidRegId) and $item->profile->androidRegId != '')
                    {
                        \App\Models\UserDevice::create([
                            'user_id' => $user->id,
                            'push_token' => $item->profile->androidRegId,
                            'platform' => 'android'
                        ]);
                    }
                }
            }
        }
    }

}
