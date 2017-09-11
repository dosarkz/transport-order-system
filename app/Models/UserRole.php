<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    const RoleDriver = 4;
    const RoleClient = 2;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role_id', 'user_id', 'status_id'
    ];

    public $timestamps = true;


    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}

