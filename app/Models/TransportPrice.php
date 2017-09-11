<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TransportPrice extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'service_id', 'price_option_id', 'status_id'
    ];

    /**
     * @var bool
     */
    public $timestamps = true;

    public function priceOption()
    {
        return $this->belongsTo(PriceOption::class, 'price_option_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function priceOptions()
    {
        return self::where('service_id', $this->service_id)->get();
    }

    public function checkService($transport)
    {
        return true == TransportService::where('service_id', $this->service_id)
            ->where('transport_id', $transport->id)->first();
    }

    public function getOptionValue($transport)
    {
       $priceOption = TransportServicePriceOption::where('price_option_id',$this->price_option_id)
           ->whereHas('transportService', function($query) use($transport){
               $query->where('service_id', $this->service_id)
                   ->where('transport_id', $transport->id);
           })
            ->where('transport_id', $transport->id)
            ->first();

        if($priceOption)
        {
            return $priceOption->price;
        }

        return null;
    }

}