<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class OrderStatus extends Model
{
    public $table = 'order_statuses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'status_text', 'active','status_id'
    ];

    /**
     * @var bool
     */
    public $timestamps = true;


}