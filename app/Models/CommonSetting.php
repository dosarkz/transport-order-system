<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class CommonSetting extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'gps_update_interval', 'route_map_update_interval', 'oferta_title', 'oferta_body', 'status_id'
    ];

    /**
     * @var bool
     */
    public $timestamps = false;


}