<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TransportDocument extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'user_id', 'transport_id', 'status_id', 'file_id', 'type','document_type_id','date_to'
    ];

    /**
     * @var bool
     */
    public $timestamps = true;

    public function documentType()
    {
        return $this->belongsTo(DocumentType::class, 'document_type_id');
    }

    public function file()
    {
        return $this->belongsTo(File::class, 'file_id');
    }

    public function getUrlAttribute()
    {
        return $this->file->path . $this->file->name;
    }

}