<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TransportImage extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'image_id', 'transport_id', 'is_main', 'status_id', '_public_image_id'
    ];

    /**
     * @var bool
     */
    public $timestamps = true;

    public function image()
    {
        return $this->belongsTo(Image::class, 'image_id');
    }


}