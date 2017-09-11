<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;


class Project extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'name', 'company_type','company_name','company_name_full', 'director_name', 'f_director_name', 'fact_address',
        'legal_address', 'phone', 'email', 'description', 'bin', 'bank_name', 'bank_account','bank_bik', 'nds_value',
        'is_nds', 'user_id','status_id'
    ];

    /**
     * @var bool
     */
    public $timestamps = true;

    public function orders()
    {
        return $this->hasMany(Order::class, 'project_id', 'id');
    }

    public function registries()
    {
        return $this->hasMany(Registry::class, 'project_id', 'id');
    }

    public function services()
    {
        return $this->hasMany(ProjectService::class, 'project_id');
    }

    public function contractor()
    {
        return $this->belongsTo(Contractor::class, 'project_id');
    }

    public function getListBrandsByCategoryAttribute()
    {
        return TransportBrand::whereHas('transport_brand_categories', function($query){
            $query->where('category_id', request()->input('transport_category_id'));
        })->orderBy('name', 'asc')->pluck('name','id');
    }

    public function operators()
    {
        return $this->hasMany(ProjectOperator::class, 'project_id');
    }

}