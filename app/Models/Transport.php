<?php
namespace App\Models;
use App\Classes\GroupInput;
use Collective\Html\FormFacade;
use Illuminate\Database\Eloquent\Model;

class Transport extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'car_category_id', 'car_driver_id','car_brand_id', 'car_class_type_id','car_model_type_id','car_gos_number',
        'car_production_year_id','car_hourly_price','city_id','car_seats', 'car_color','kind_of_property'
    ];

    /**
     * @var bool
     */
    public $timestamps = true;

    public function transportServices()
    {
        return $this->hasMany(TransportService::class, 'transport_id');
    }

    public function transportImages()
    {
        return $this->hasMany(TransportImage::class, 'transport_id');
    }

    public function driver()
    {
        return $this->belongsTo(User::class, 'car_driver_id');
    }

    public function transportBrand()
    {
        return $this->belongsTo(TransportBrand::class, 'car_brand_id');
    }

    public function transportCategory()
    {
        return $this->belongsTo(TransportCategory::class, 'car_category_id');
    }

    public function transportModel()
    {
        return $this->belongsTo(TransportModel::class, 'car_model_type_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class,'city_id');
    }

    public function transportDocument()
    {
        return $this->hasMany(TransportDocument::class, 'transport_id');
    }

    public function transportPriceOptions()
    {
        return $this->hasMany(TransportServicePriceOption::class, 'transport_id');
    }

    public function isFavourite()
    {
        return $this->belongsTo(UserFavouriteCar::class, 'id', 'transport_id');
    }

    public function userFavourites()
    {
        return $this->hasMany(UserFavouriteCar::class, 'transport_id');
    }

    public function getCategoryAttribute()
    {
        $category = null;

        if(request()->has('service_id'))
        {
            $category = sprintf('?service_id=%s',request()->input('service_id'));
        }

        if(request()->has('category_id'))
        {
            $category = sprintf('?category_id=%s',request()->input('category_id'));
        }

        return $category;
    }

}