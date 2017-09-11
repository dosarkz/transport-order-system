<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;


class Registry extends Model
{
    const STATUS_COMPLETE = 5;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'start_time', 'end_time', 'order_id', 'project_id', 'tariff_id', 'tariff_name', 'driver_id', 'car_id', 'start_point',
        'end_point', 'value', 'work_type', 'comment_text', 'status_id','user_id'
    ];

    /**
     * @var bool
     */
    public $timestamps = true;

    public function priceOption()
    {
        return $this->belongsTo(PriceOption::class, 'tariff_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function getListStatusesAttribute()
    {
        return [
//            1 => 'Отработан',
            2 => 'Срыв',
            3 => 'Замена',
            4 => 'Выходной',
            5 => 'Закрыт'
        ];
    }

    public function getStartTimeAttribute($value)
    {
        return date('d.m.Y, H:i', strtotime($value));
    }

    public function getStartTimePickerAttribute()
    {
        return date('H:i', strtotime($this->start_time));
    }

    public function getEndTimePickerAttribute()
    {
        return date('H:i', strtotime($this->end_time));
    }

    public function getEndTimeAttribute($value)
    {
        return date('d.m.Y, H:i', strtotime($value));
    }

    public function getCreatedAtAttribute($value)
    {
        return date('d.m.Y, H:i', strtotime($value));
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

}