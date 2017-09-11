<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class TransportBrandCategory extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id', 'transport_brand_id'
    ];

    /**
     * @var bool
     */
    public $timestamps = true;
}