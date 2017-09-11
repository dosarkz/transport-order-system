<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Service extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'position','image_id', 'status_id','_image_id'
    ];

    /**
     * @var bool
     */
    public $timestamps = true;

    public function transportServices()
    {
        return $this->hasMany(TransportService::class, 'service_id');
    }

    public function countTransportServicesByCity()
    {
        if(request()->has('city_id')) {
            $city_id = request()->input('city_id');

            return Transport::whereHas('transportServices', function($query)
            {
                $query->where('service_id', $this->id);
            })->where('city_id', $city_id)->count();
        }

        $city = auth()->user()->city_id ? auth()->user()->city_id : 10;

        return Transport::whereHas('transportServices', function($query)
        {
            $query->where('service_id', $this->id);
        })->where('city_id', $city)->count();
    }


}