<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aobject extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at', "created_at", "updated_at", "date"];

    public function scopeToday($query) {
        return $query->whereDate('created_at', date('Y-m-d'));
    }

    public function scopeTodayK($query) {
        return $query->whereDate('created_at', date('Y-m-d'))->whereCategory(1);
    }

    public function scopeTodayH($query) {
        return $query->whereDate('created_at', date('Y-m-d'))->whereCategory(2);
    }

    public function scopeTodayC($query) {
        return $query->whereDate('created_at', date('Y-m-d'))->whereCategory(3);
    }

    public function scopeYesterday($query) {
        return $query->whereDate('created_at', date('Y-m-d', strtotime( '-1 days' )));
    }

    public function scopeYesterdayK($query) {
        return $query->whereDate('created_at', date('Y-m-d', strtotime( '-1 days' )))->whereCategory(1);
    }

    public function scopeYesterdayH($query) {
        return $query->whereDate('created_at', date('Y-m-d', strtotime( '-1 days' )))->whereCategory(2);
    }

    public function scopeYesterdayC($query) {
        return $query->whereDate('created_at', date('Y-m-d', strtotime( '-1 days' )))->whereCategory(3);
    }

    public function scopeK($query) {
    	return $query->whereCategory(1);
    }

    public function scopeH($query) {
    	return $query->whereCategory(2);
    }

    public function scopeC($query) {
    	return $query->whereCategory(3);
    }
}
