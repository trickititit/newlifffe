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
        'name', 'email', 'password', 'login', 'telefon', 'role_id'
    ];

    public function polices(){
        return $this->belongsToMany('App\Police');
    }

    public function favorites(){
        return $this->belongsToMany('App\Object');
    }

    public function a_favorites(){
        return $this->belongsToMany('App\Aobject');
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role() {
        return $this->belongsTo('App\Role');
    }

    public function scopeRieltors($query) {
        return $query->where("role_id", "!=", "2");
    }
    
    public function completedObjects() {
        return $this->hasMany('App\Object', "completed_id");
    }

    public function isAdmin() {
        return $this->role->name == "admin";
    }
}
