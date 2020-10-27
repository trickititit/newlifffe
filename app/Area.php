<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    //
    public function objects() {
        return $this->hasMany('App\Object', 'area');
    }
}
