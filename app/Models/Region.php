<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class Region extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name_ru', 'name_kz','name_en', 'country_id'
    ];

    /**
     * @var bool
     */
    public $timestamps = false;


}