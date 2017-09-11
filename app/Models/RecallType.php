<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class RecallType extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type', 'status_id', 'title'
    ];

    /**
     * @var bool
     */
    public $timestamps = true;


}