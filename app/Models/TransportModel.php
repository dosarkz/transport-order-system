<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class TransportModel extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'status_id','position', 'category_id', 'brand_id','class_id',
    ];

    /**
     * @var bool
     */
    public $timestamps = true;


}