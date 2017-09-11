<?php

namespace App\Models;

use App\Classes\Menu;
use App\Classes\RoleMenu;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'user_role_id', 'first_name', 'last_name','image_id', 'company','birthday',
        'gender','city_id', 'driver_about', 'latitude','longitude', 'location_updated_at', '_id', '_image_id', 'become_driver'
    ];

    protected $guarded = array();

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function menu()
    {
        $menu = new RoleMenu($this->user_role);
        return $menu->render();
    }

    public function user_role()
    {
        return $this->belongsTo(UserRole::class, 'user_role_id');
    }

    public function getFullNameAttribute()
    {
        return $this->first_name. ' '. $this->last_name;
    }


    public function getFullNameWithPhoneAttribute()
    {
        return $this->first_name.' '. $this->last_name .'  '. $this->phone;
    }

    public function getFullNameWithAutoAttribute()
    {
        return $this->first_name.' '. $this->last_name .'  '. $this->phone;
    }

    public function getBirthdayAttribute($value)
    {
        return date('d.m.Y', strtotime($value));
    }

    public function isDriver()
    {
        $driver_role =  UserRole::where([
            'user_id' => auth()->user()->id,
            'role_id' => Role::where('alias', 'driver')->first()->id
        ])->first();

        if($driver_role)
        {
            return auth()->user()->user_role_id === $driver_role->id;
        }

        return false;
    }

    public function driverServices()
    {
        return $this->hasMany(UserDriverService::class, 'user_id');
    }

    public function driverLicenses()
    {
        return $this->hasMany(UserDriverLicense::class, 'user_id');
    }

    public function userRoles()
    {
        return $this->hasMany(UserRole::class, 'user_id');
    }

    public function hasRole($role)
    {
        if(!auth()->guest())
        {
            return auth()->user()->userRoles()->whereHas('role',function($query) use($role){
                $query->where('alias', $role);
            })->first() ? true : false;
        }

        return false;
    }

    public function transports()
    {
        return $this->hasMany(Transport::class, 'car_driver_id');
    }

    public function projectsLists($projectOperators)
    {
        $list =  [];

        if(!auth()->user()->hasRole('admin'))
        {
            foreach ($projectOperators as $projectOperator) {
                $list[] = new Menu($projectOperator->project->name, '/projects/'.$projectOperator->project->id, 'fa-list',[], 1);
            }
        }else{
            foreach (Project::all() as $item) {
                if($item->name)
                {
                    $list[] = new Menu($item->name, '/projects/'.$item->id, 'fa-list',[], 1);
                }

            }
        }

        if(auth()->user()->hasRole('admin'))
        {
            $list[] = new Menu('Список проектов', '/projects', 'fa-list',[], 1);
            $list[] = new Menu('Добавить', '/projects/create', 'fa-plus',[], 1);
        }

        return $list;
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'driver_id');
    }

    public function projectOperator()
    {
        return $this->belongsTo(ProjectOperator::class, 'id', 'user_id');
    }

    public function userDevices()
    {
        return $this->hasMany(UserDevice::class, 'user_id');
    }



}
