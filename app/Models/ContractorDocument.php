<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class ContractorDocument extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      '_id', 'start_at', 'stop_at', 'file_type', 'file_type_name', 'file_number', 'file_price', 'description',
        'file_extension','file_id', 'user_id', 'status_id', 'project_id', 'contractor_id'
    ];

    public function getStartAtAttribute($value)
    {
        return date('Y-m-d', strtotime($value));
    }

    public function getStopAtAttribute($value)
    {
        return date('Y-m-d', strtotime($value));
    }

    public function file()
    {
        return $this->belongsTo(File::class, 'file_id');
    }


    /**
     * @var bool
     */
    public $timestamps = true;


}