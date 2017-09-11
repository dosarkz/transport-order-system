<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TransportService extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'service_id', 'transport_id', 'status_id',
    ];

    /**
     * @var bool
     */
    public $timestamps = true;


    public function transports()
    {
        return $this->hasMany(Transport::class, 'transport_id', 'id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function servicePriceOptions()
    {
        return $this->hasMany(TransportServicePriceOption::class, 'transport_service_id');
    }


}