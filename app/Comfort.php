<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comfort extends Model
{
    public function objects(){
        return $this->belongsToMany('App\Object');
    }
}
