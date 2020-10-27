<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    
    public function object() {
        return $this->belongsTo('App\Object');
    }
    
}
