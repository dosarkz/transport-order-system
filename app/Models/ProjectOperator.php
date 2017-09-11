<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;


class ProjectOperator extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'project_id','phone', 'post_text', 'post_id', 'first_name', 'last_name', 'user_id','status_id'
    ];

    /**
     * @var bool
     */
    public $timestamps = true;

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getPostAttribute()
    {
        return $this->postList()[$this->post_id];
    }

    public function postList()
    {
        return [
            1 => 'Менеджер',
            2 => 'Диспетчер',
            3 => 'Механик',
            4 => 'Офис менеджер',
            5 => 'Бухгалтер',
            6 => 'Юрист',
            7 => 'Программист'
        ];
    }

}