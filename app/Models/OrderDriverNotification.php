<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class OrderDriverNotification extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id', 'transport_id', 'driver_id', 'status_id'
    ];

    /**
     * @var bool
     */
    public $timestamps = true;

    public function getTransportInfoAttribute()
    {
        $list = '';

        $transport =  Transport::find($this->transport_id);

        if($transport->transportBrand)
        {
            $list = $transport->transportBrand->name .' | '.$transport->car_gos_number.'  - '.
                $transport->driver->fullName;
        }
        return $list;
    }

}