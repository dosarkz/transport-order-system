<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Order extends Model
{
    const STATUS_IN_PROCESSING = 0;
    const STATUS_TO_WORK = 1;
    const STATUS_CLIENT_COMPLETED = 2;
    const STATUS_DRIVER_COMPLETED = 3;
    const STATUS_CLIENT_REJECTED = 4;
    const STATUS_DRIVER_REJECTED = 5;
    const STATUS_DRIVER_SELECTED = 6;
    const STATUS_SUPPLIER_SELECTED = 7;
    const TYPE_ORDER_SERVICE = 1;
    const TYPE_CLIENT_ORDER = 2;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'type_id','service_id', 'date_start','date_end','description','phone','device','car_id','car_category_id',
        'car_brand_id','car_model_id','amount_of_work','tariff_id','city_id','project_id','contractor_id','client_accepted_at',
        'finished_user_id','finished_at','canceled_at','canceled_user_id','start_point_text','start_point_latitude',
        'start_point_longitude','end_point_text','end_point_latitude','end_point_longitude','client_price','client_phone',
        'driver_id','driver_price','client_document_id','client_document_text','client_document_type','order_service_id',
        'order_service_name','driver_contractor_id','driver_contractor_text','status_id', 'amount', 'car_production_year_id'
    ];

    /**
     * @var bool
     */
    public $timestamps = true;

    public function status()
    {
        return $this->belongsTo(OrderStatus::class, 'status_id','status_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function transportCategory()
    {
        return $this->belongsTo(TransportCategory::class, 'car_category_id');
    }

    public function transport()
    {
        return $this->belongsTo(Transport::class, 'car_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getStatusAttribute()
    {
        $status = OrderStatus::where('status_id', $this->status_id)->first();

        if($status)
        {
            return $status;
        }

        return false;
    }

    public function getHasRequestAttribute()
    {
        return OrderDriverRequest::where('user_id', auth()->user()->id)
            ->where('order_id', $this->id)
            ->first();
    }

    public function transportRequests()
    {
        return $this->hasMany(OrderDriverRequest::class, 'order_id');
    }

    public function getDateStartAttribute($value)
    {
        return date('d.m.Y, H:i', strtotime($value));
    }

    public function getCreatedAtAttribute($value)
    {
        return date('d.m.Y, H:i', strtotime($value));
    }

    public function getDateEndAttribute($value)
    {
        return date('d.m.Y, H:i', strtotime($value));
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function contractor()
    {
        return $this->belongsTo(Contractor::class, 'contractor_id');
    }

    public function orderService()
    {
        return $this->belongsTo(ProjectService::class, 'order_service_id');
    }

    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    public function priceOption()
    {
        return $this->belongsTo(PriceOption::class, 'tariff_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function registries()
    {
        return $this->hasMany(Registry::class, 'order_id');
    }

    public function getProjectServicesAttribute()
    {
        return ProjectService::where('project_id', $this->project_id)->pluck('name', 'id');
    }

    public function getCitiesListAttribute()
    {
        return City::orderBy(DB::raw('id IN(12, 10)'), 'desc')
            ->orderBy('name_ru', 'asc')
            ->pluck('name_ru', 'id');
    }

    public function contractorFileType()
    {
        return $this->belongsTo(ContractorFileType::class, 'client_document_type');
    }

    public function getDriversListAttribute()
    {
        return  Transport::join('transport_brands', 'transports.car_brand_id', '=', 'transport_brands.id')
            ->join('users', 'transports.car_driver_id', '=', 'users.id')
            ->select('transports.id', DB::raw('CONCAT(transport_brands.name,\' | \', transports.car_gos_number,\' - \', users.first_name,\' \', users.last_name) as text'))
            ->where('transports.car_brand_id', $this->car_brand_id)
            ->where('transports.car_category_id', $this->car_category_id)
            ->where('transports.car_model_type_id', $this->car_model_id)
            ->orWhere('transports.id', $this->car_id)
            ->pluck('text', 'id');
    }

    public function contractorPhones()
    {
        return $this->hasMany(OrderContractorPhone::class, 'order_id');
    }

    public function transports()
    {
        return $this->hasMany(OrderTransport::class, 'order_id');
    }

    public function phones()
    {
        return $this->hasMany(OrderContractorPhone::class, 'order_id');
    }

    public function drivers()
    {
        return $this->hasMany(OrderDriverNotification::class, 'order_id');
    }

    public function getTransportBrandsListAttribute()
    {
        $transportBrand = new TransportBrand();
        return $transportBrand->whereHas('transport_brand_categories', function($query){
            $query->where('category_id', $this->car_category_id);
        })->pluck('name', 'id');
    }

    public function getTransportModelsListAttribute()
    {
        $transportModel = new TransportModel();
        return $transportModel->where('category_id', $this->car_category_id)
            ->where('brand_id', $this->car_brand_id)->pluck('name', 'id');
    }

    public function getAmountAttribute()
    {
        $registries = Registry::where('order_id', $this->id)->get();
        $amount = 0;

        foreach ($registries as $registry) {
            $amount += $registry->value;
        }
        return $amount;
    }




}