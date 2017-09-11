<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class OrderDriverRequest extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'car_id', 'price', 'order_id', 'status_id'
    ];

    /**
     * @var bool
     */
    public $timestamps = true;

    public function transport()
    {
        return $this->belongsTo(Transport::class, 'car_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


}