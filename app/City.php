<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    //
    public function objects() {
        return $this->hasMany('App\Object', 'city');
    }

    public function areas(){
        return $this->hasMany('App\Area');
    }
}
