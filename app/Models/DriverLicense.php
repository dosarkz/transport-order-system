<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class DriverLicense extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'status_id'
    ];

    /**
     * @var bool
     */
    public $timestamps = true;


}