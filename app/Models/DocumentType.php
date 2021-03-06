<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class DocumentType extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'status_id', 'type'
    ];

    /**
     * @var bool
     */
    public $timestamps = true;


}