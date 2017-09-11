<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class Contractor extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_type', 'company_name', 'company_name_full', 'director_name', 'f_director_name', 'fact_address',
        'legal_address', 'phone', 'email', 'description', 'bin', 'bank_name', 'bank_account','bank_bik', 'nds_value',
        'is_nds', 'user_id','status_id', 'project_id', 'is_provider'
    ];

    /**
     * @var bool
     */
    public $timestamps = true;

    public function companyType()
    {
        return $this->belongsTo(CompanyType::class, 'company_type');
    }


}