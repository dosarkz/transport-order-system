<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    const ROLE_OPERATOR = 6;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'alias', 'parent_role_id',
    ];

    public $timestamps = true;
}

