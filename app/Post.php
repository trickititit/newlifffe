<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
    protected $fillable = [
        'title', 'text', 'desc', 'image', 'alias', 'on_main', 'section_id'
    ];

    public function section() {
        return $this->belongsTo('App\Section');
    }

    public function scopeOnMain($query) {
        return $query->whereOn_main('1');
    }

    public function scopeFAQ($query) {
        return $query->whereSection_id('1');
    }
}
