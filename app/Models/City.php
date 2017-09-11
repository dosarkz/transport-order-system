<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;


class City extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name_ru', 'name_kz','name_en', 'country_id','region_id','latitude','longitude'
    ];

    /**
     * @var bool
     */
    public $timestamps = false;

    public function getNameAttribute()
    {
        $locale = 'name_'.App::getLocale();
        return $this->$locale;
    }

    public function scopeListByCountry($query)
    {
        return $query->where('country_id', $this->country_id);
    }

}