<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Call extends Model
{
    protected $dates = ["created_at", "updated_at", "exec_at"];

    protected $fillable = [
        'number', 'url', 'status', 'exec_at', 'object_id'
    ];
}
