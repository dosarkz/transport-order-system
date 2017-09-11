<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;


class Country extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name_ru', 'name_kz','name_en', 'code','continent_id','name'
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

    public function getCities()
    {
        return City::where('country_id',$this->id)->lists('name_ru','id');
    }

}