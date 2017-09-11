<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TransportServicePriceOption extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'transport_service_id', 'transport_id', 'status_id', 'price','status_id', 'price_option_id'
    ];

    /**
     * @var bool
     */
    public $timestamps = true;

    public function priceOption()
    {
        return $this->belongsTo(PriceOption::class, 'price_option_id');
    }

    public function transportService()
    {
        return $this->belongsTo(TransportService::class, 'transport_service_id');
    }

}