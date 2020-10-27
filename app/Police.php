<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Police extends Model
{
    public function users(){
        return $this->belongsToMany('App\User');
    }
}
