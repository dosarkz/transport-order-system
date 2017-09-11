<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;


class ProjectService extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'project_id', 'name','status_id', '_id'
    ];

    /**
     * @var bool
     */
    public $timestamps = true;

}