<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class TransportClass extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'status_id','position', 'category_id','type_id'
    ];

    /**
     * @var bool
     */
    public $timestamps = true;


}