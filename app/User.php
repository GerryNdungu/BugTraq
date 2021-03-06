<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'lastname',
        'avatar',
        'emp_id',
        'dept',
        'phone_no',
        'user_group',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function projects()
    {
        return $this->belongsTo('App\Project');
    }

    public function tasks()
    {
        return $this->belongsToMany('App\Task');
    }

    public function comments(){
        return $this->morphMany('App\Comment','commentable');
    }

}
