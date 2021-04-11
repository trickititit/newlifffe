<?php

namespace App;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Subject
 *
 * @property Comfort[] $comforts
 * @property Area $raion
 * @property City $gorod
 * @property Image[] $images
 * @property Call[] $calls
 * @property User[] $users
 * @property User $preworkingUser
 * @property User $createdUser
 * @property User $workingUser
 * @property User $deletedUser
 * @property User $completedUser
 *
 * @package App
 */

class Subject extends Model
{
    use SoftDeletes;

    protected $table = 'objects';

    protected $dates = ['deleted_at', "activate_at", "created_at", "updated_at", "worked_at", "outed_at"];

    public function comforts()
    {
        return $this->belongsToMany('App\Comfort', 'object_user', 'object_id', 'object_id');
    }

    public function raion()
    {
        return $this->belongsTo('App\Area', 'area');
    }

    public function gorod()
    {
        return $this->belongsTo('App\City', 'city');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany('App\Image', 'object_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function calls()
    {
        return $this->hasMany('App\Call', 'object_id');
    }

    public function getViewPrice()
    {
        return number_format($this->price, 0, '', ' ');
    }

    public function getViewAddress()
    {
        $city = str_replace(array("Волжский", "Волгоград"), array("Влж", "Влг"), $this->gorod->name);
        $area = (isset($this->raion)) ?? str_replace(array("микрорайон", "улица", "Квартал", "квартал", "поселок"),
                array("мкр", "ул", "кв-л", "кв-л", "п"), $this->raion->name);

        return $city . ", " . $area . ", " . $this->address;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function preworkingUser()
    {
        return $this->belongsTo('App\Models\User', 'pre_working_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function createdUser()
    {
        return $this->belongsTo('App\Models\User', 'created_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function workingUser()
    {
        return $this->belongsTo('App\Models\User', 'working_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function deletedUser()
    {
        return $this->belongsTo('App\Models\User', 'deleted_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function completedUser()
    {
        return $this->belongsTo('App\Models\User', 'completed_id');
    }

    public function scopeMy($query)
    {
        $user_id = Auth::user()->id;
        return $query->whereCreated_id($user_id)->whereCompleted_id(null);
    }

    public function scopeInWork($query)
    {
        $user_id = Auth::user()->id;
        return $query->whereWorking_id($user_id);
    }

    public function scopeInWorkAndMaybeCompleted($query)
    {
        $user_id = Auth::user()->id;
        return $query->whereWorking_id($user_id);
    }

    public function scopeInPreWork($query)
    {
        return $query->wherenotNull("working_id");
    }

    public function scopeCompleted($query)
    {
        $user_id = Auth::user()->id;
        return $query->whereCompleted_id($user_id);
    }

    public function scopeSpecOffer($query)
    {
        return $query->whereSpec_offer(1);
    }

    public function scopeInWorkAll($query)
    {
        return $query->wherenotNull("working_id");
    }

    public function scopeOuted($query)
    {
        return $query->whereOut("1");
    }

    public function scopeOutedAvito($query)
    {
        return $query->whereOut_avito("1");
    }

    public function scopeOutedYandex($query)
    {
        return $query->whereOut_yandex("1");
    }

    public function scopeOutedClick($query)
    {
        return $query->whereOut_click("1");
    }

    public function scopeOutedAll($query)
    {
        return $query->whereOut_all("1");
    }

    public function scopeMyOuted($query)
    {
        $user_id = Auth::user()->id;
        return $query->whereOut("1")->whereWorking_id($user_id);
    }

    public function scopeInNotWorkAll($query)
    {
        return $query->whereNull("working_id");
    }

    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'object_user', 'object_id', 'object_id');
    }
}
