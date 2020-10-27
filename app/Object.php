<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class Object extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at', "activate_at", "created_at", "updated_at", "worked_at", "outed_at"];
    
    public function comforts(){
        return $this->belongsToMany('App\Comfort');
    }

    public function raion() {
        return $this->belongsTo('App\Area', 'area');
    }

    public function gorod() {
        return $this->belongsTo('App\City', 'city');
    }
    
    public function images() {
        return $this->hasMany('App\Image');
    }

    public function calls() {
        return $this->hasMany('App\Call');
    }

    public function getViewPrice() {
        return number_format($this->price, 0, '', ' ');
    }

    public function getViewAddress() {
        $city = str_replace(array("Волжский", "Волгоград"), array("Влж", "Влг"), $this->gorod->name);
        $area = (isset($this->raion)) ?? str_replace(array("микрорайон", "улица", "Квартал", "квартал", "поселок"), array("мкр", "ул", "кв-л", "кв-л", "п"), $this->raion->name);
        return $city.", ".$area.", ".$this->address;
    }

    public function preworkingUser() {
        return $this->belongsTo('App\User', 'pre_working_id');
    }

    public function createdUser() {
        return $this->belongsTo('App\User', 'created_id');
    }

    public function workingUser() {
        return $this->belongsTo('App\User', 'working_id');
    }

    public function deletedUser() {
        return $this->belongsTo('App\User', 'deleted_id');
    }

    public function completedUser() {
        return $this->belongsTo('App\User', 'completed_id');
    }

    public function scopeMy($query) {
        $user_id = Auth::user()->id;
        return $query->whereCreated_id($user_id)->whereCompleted_id(null);
    }

    public function scopeInWork($query) {
        $user_id = Auth::user()->id;
        return $query->whereWorking_id($user_id);
    }

    public function scopeInWorkAndMaybeCompleted($query) {
        $user_id = Auth::user()->id;
        return $query->whereWorking_id($user_id);
    }

    public function scopeInPreWork($query) {
        return $query->wherenotNull("working_id");
    }

    public function scopeCompleted($query) {
        $user_id = Auth::user()->id;
        return $query->whereCompleted_id($user_id);
    }

    public function scopeSpecOffer ($query) {
        return $query->whereSpec_offer(1);
    }

    public function scopeInWorkAll($query) {
        return $query->wherenotNull("working_id");
    }

    public function scopeOuted($query) {
        return $query->whereOut("1");
    }

    public function scopeOutedAvito($query) {
        return $query->whereOut_avito("1");
    }

    public function scopeOutedYandex($query) {
        return $query->whereOut_yandex("1");
    }

    public function scopeOutedClick($query) {
        return $query->whereOut_click("1");
    }

    public function scopeOutedAll($query) {
        return $query->whereOut_all("1");
    }

    public function scopeMyOuted($query) {
        $user_id = Auth::user()->id;
        return $query->whereOut("1")->whereWorking_id($user_id);
    }

    public function scopeInNotWorkAll($query) {
        return $query->whereNull("working_id");
    }

    public function users(){
        return $this->belongsToMany('App\User');
    }
    
}
