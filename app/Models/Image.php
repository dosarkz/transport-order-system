<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    public $timestamps = true;
    protected $fillable = ['name','thumb','path', 'status_id','user_id'];

    public function getThumb()
    {
        return $this->path . $this->thumb;
    }

    public function getFullImage()
    {
        if($this->path){
            return $this->path . $this->name;
        }
        else return false;
    }
}
