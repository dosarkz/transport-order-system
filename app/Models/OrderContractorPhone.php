<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class OrderContractorPhone extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'order_id', 'project_id', 'contractor_id', 'phone', 'status_id'
    ];

    /**
     * @var bool
     */
    public $timestamps = true;


}