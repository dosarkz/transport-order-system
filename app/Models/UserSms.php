<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class UserSms extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code', 'phone_number', 'status_id',
    ];

    public $timestamps = true;
}

