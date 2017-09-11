<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class TransportBrand extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'status_id','position'
    ];

    /**
     * @var bool
     */
    public $timestamps = true;

    public function transport_brand_categories()
    {
        return $this->hasMany(TransportBrandCategory::class, 'transport_brand_id');
    }

    public function transportModels()
    {
        return $this->hasMany(TransportModel::class, 'brand_id');
    }
}