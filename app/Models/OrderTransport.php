<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class OrderTransport extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'order_id', 'project_id', 'transport_id', 'user_id', 'driver_id', 'transport_category_id', 'transport_brand_id',
        'transport_model_id', 'status_id'
    ];

    /**
     * @var bool
     */
    public $timestamps = true;


    public function getListTransportBrandsAttribute()
    {
        return TransportBrand::whereHas('transport_brand_categories', function($query){
            $query->where('category_id', $this->transport_category_id);
        })->pluck('name', 'id');
    }

    public function getListTransportModelsAttribute()
    {
        return TransportModel::where('brand_id', $this->transport_brand_id)
            ->where('category_id', $this->transport_category_id)
            ->pluck('name', 'id');
    }

}