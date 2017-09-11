<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class UserDriverLicense extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'driver_license_id', 'status_id'
    ];

    public $timestamps = true;


}

