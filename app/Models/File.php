<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    public $timestamps = true;
    protected $fillable = ['name','thumb','path', 'status_id','user_id', 'url', 'etag', '_public_id'];

    public function getFile()
    {
        return '/'. $this->path. $this->name;
    }
}
