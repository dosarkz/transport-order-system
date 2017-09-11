<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class UserFavouriteCar extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'transport_id','user_id', 'status_id'
    ];

    /**
     * @var bool
     */
    public $timestamps = true;


}