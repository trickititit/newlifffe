<?php

namespace App\Http\Controllers\Admin;

use App\Components\JavaScriptMaker;
use Illuminate\Http\Request;
use App\Object;
use App\AObject;

class FavoriteController extends AdminController
{
    protected $c_rep;

    public function __construct() {
        parent::__construct(new \App\Repositories\AdmMenusRepository(new \App\AdmMenu), new \App\Repositories\SettingsRepository(new \App\Setting()), new \App\Repositories\AobjectsRepository(new \App\Aobject()), new \App\User);
        $this->template = config('settings.theme').'.admin.index';
    }

    public function index(JavaScriptMaker $jsmaker) {
        $this->checkUser();
        $jsmaker->setJs("filter", "", true, "", $this->randStr);
        $favorites = $this->user->favorites()->get();
        $a_favorites = $this->user->a_favorites()->get();
        $actions = array();
        foreach ($favorites as $object) {
            $actions = array_add($actions,"object".$object->id, $this->getActions($object, $this->user, ""));
            $object->client = json_decode($object->client);
        }
        foreach ($a_favorites as $object) {
            $actions = array_add($actions,"object".$object->id, $this->getAobjActions($object));
            $object->client = json_decode($object->client);
        }
        $this->content = view(config('settings.theme').'.admin.favorites')->with(array("favorites" => $favorites, "a_favorites" => $a_favorites, "actions" => $actions))->render();
        $this->title = 'Избранное';
        return $this->renderOutput();
    }

    public function Favorite(Request $request, Object $object){
        $this->checkUser();
        if($request->type == "add"){
            $this->user->favorites()->attach($object->id);
            $this->user->update();
        } else if ($request->type == "delete") {
            $this->user->favorites()->detach($object->id);
            $this->user->update();
        }else if ($request->type == "fulldelete") {
            $this->user->favorites()->detach($object->id);
            $this->user->update();
            return back();
        } else {
            return false;
        }
        return response()->json([
            'id' => $object->id
        ]);
    }

    public function AFavorite(Request $request, AObject $object){
        $this->checkUser();
        if($request->type == "add"){
            $this->user->a_favorites()->attach($object->id);
            $this->user->update();
        } else if ($request->type == "delete") {
            $this->user->a_favorites()->detach($object->id);
            $this->user->update();
        }else if ($request->type == "fulldelete") {
            $this->user->a_favorites()->detach($object->id);
            $this->user->update();
            return back();
        } else {
            return false;
        }
        return response()->json([
            'id' => $object->id
        ]);
    }

    private function getActions($object, $user, $type) {
        switch ($type) {
            case "outed":
                $editlink = route('object.edit',['object'=>$object->alias]);
                $unworklink = route('object.unwork',['object'=>$object->alias]);
                $unoutlink = route('object.unout',['object'=>$object->alias]);
                $uninwork = "<form action='$unworklink' method='post'><input type=\"hidden\" name=\"_method\" value=\"PUT\"><input type=\"hidden\" name=\"_token\" value=\"".csrf_token()."\"><button class='btn btn-secondary btn-sm' type='submit' data-toggle=\"tooltip\" data-placement=\"bottom\" title='Убрать из работы'><i class=\"fa fa-gear fa-lg\"></i></button></form>";
                $deletelink = route('object.softDelete',['object'=>$object->alias]);
                $delete = "<form action='$deletelink' method='post'><input type=\"hidden\" name=\"_method\" value=\"DELETE\"><input type=\"hidden\" name=\"_token\" value=\"".csrf_token()."\"><button class='btn btn-secondary btn-sm' type='submit' data-toggle=\"tooltip\" data-placement=\"bottom\" title='Удалить'><i class=\"fa fa-trash fa-lg\"></i></button></form>";
                $edit = "<a class='btn btn-secondary btn-sm' href='$editlink' data-toggle=\"tooltip\" data-placement=\"bottom\" title='Редактировать'><i class=\"fa fa-edit fa-lg\"></i></a>";
                $unout = "<form action='$unoutlink' method='post'><input type=\"hidden\" name=\"_method\" value=\"DELETE\"><input type=\"hidden\" name=\"_token\" value=\"".csrf_token()."\"><button class='btn btn-secondary btn-sm' type='submit' data-toggle=\"tooltip\" data-placement=\"bottom\" title='Убрать с выгрузки'><i class=\"fa fa-times fa-lg\"></i></button></form>";
                return $edit.$uninwork.$unout.$delete;
            case "myouted":
                $editlink = route('object.edit',['object'=>$object->alias]);
                $unworklink = route('object.unwork',['object'=>$object->alias]);
                $unoutlink = route('object.unout',['object'=>$object->alias]);
                $uninwork = "<form action='$unworklink' method='post'><input type=\"hidden\" name=\"_method\" value=\"PUT\"><input type=\"hidden\" name=\"_token\" value=\"".csrf_token()."\"><button class='btn btn-secondary btn-sm' type='submit' data-toggle=\"tooltip\" data-placement=\"bottom\" title='Убрать из работы'><i class=\"fa fa-gear fa-lg\"></i></button></form>";
                $deletelink = route('object.softDelete',['object'=>$object->alias]);
                $delete = "<form action='$deletelink' method='post'><input type=\"hidden\" name=\"_method\" value=\"DELETE\"><input type=\"hidden\" name=\"_token\" value=\"".csrf_token()."\"><button class='btn btn-secondary btn-sm' type='submit' data-toggle=\"tooltip\" data-placement=\"bottom\" title='Удалить'><i class=\"fa fa-trash fa-lg\"></i></button></form>";
                $edit = "<a class='btn btn-secondary btn-sm' href='$editlink' data-toggle=\"tooltip\" data-placement=\"bottom\" title='Редактировать'><i class=\"fa fa-edit fa-lg\"></i></a>";
                $unout = "<form action='$unoutlink' method='post'><input type=\"hidden\" name=\"_method\" value=\"DELETE\"><input type=\"hidden\" name=\"_token\" value=\"".csrf_token()."\"><button class='btn btn-secondary btn-sm' type='submit' data-toggle=\"tooltip\" data-placement=\"bottom\" title='Убрать с выгрузки'><i class=\"fa fa-times fa-lg\"></i></button></form>";
                return $edit.$uninwork.$unout.$delete;
            case "inwork":
                $editlink = route('object.edit',['object'=>$object->alias]);
                $unworklink = route('object.unwork',['object'=>$object->alias]);
                $outlink = route('object.out',['object'=>$object->alias]);
                $uninwork = "<form action='$unworklink' method='post'><input type=\"hidden\" name=\"_method\" value=\"PUT\"><input type=\"hidden\" name=\"_token\" value=\"".csrf_token()."\"><button class='btn btn-secondary btn-sm' type='submit' data-toggle=\"tooltip\" data-placement=\"bottom\" title='Убрать из работы'><i class=\"fa fa-gear fa-lg\"></i></button></form>";
                $deletelink = route('object.softDelete',['object'=>$object->alias]);
                $delete = "<form action='$deletelink' method='post'><input type=\"hidden\" name=\"_method\" value=\"DELETE\"><input type=\"hidden\" name=\"_token\" value=\"".csrf_token()."\"><button class='btn btn-secondary btn-sm' type='submit' data-toggle=\"tooltip\" data-placement=\"bottom\" title='Удалить'><i class=\"fa fa-trash fa-lg\"></i></button></form>";
                $edit = "<a class='btn btn-secondary btn-sm' href='$editlink' data-toggle=\"tooltip\" data-placement=\"bottom\" title='Редактировать'><i class=\"fa fa-edit fa-lg\"></i></a>";
                $out = "<form action='$outlink' method='post'><input type=\"hidden\" name=\"_method\" value=\"PUT\"><input type=\"hidden\" name=\"_token\" value=\"".csrf_token()."\"><button class='btn btn-secondary btn-sm' type='submit' data-toggle=\"tooltip\" data-placement=\"bottom\" title='Выгрузить'><i class=\"fa fa-retweet fa-lg\"></i></button></form>";
                return $edit.$uninwork.$out.$delete;
            case "prework":
                $who = $object->preworkingUser->name;
                $acceptlink = route('object.accessPreWork',['object'=>$object->alias]);
                $canсelllink = route('object.cancelPreWork',['object'=>$object->alias]);
                $who_pre = "<p style='color: #BABABA'>От ".$who."</p>";
                $accept = "<form action='$acceptlink' method='post'><input type=\"hidden\" name=\"_method\" value=\"PUT\"><input type=\"hidden\" name=\"_token\" value=\"".csrf_token()."\"><button class='btn btn-secondary btn-sm' type='submit' data-toggle=\"tooltip\" data-placement=\"bottom\" title='Подтвердить'><i class=\"fa fa-check fa-lg\"></i></button></form>";
                $canсell = "<form action='$canсelllink' method='post'><input type=\"hidden\" name=\"_method\" value=\"PUT\"><input type=\"hidden\" name=\"_token\" value=\"".csrf_token()."\"><button class='btn btn-secondary btn-sm' type='submit' data-toggle=\"tooltip\" data-placement=\"bottom\" title='Отклонить'><i class=\"fa fa-ban fa-lg\"></i></button></form>";
                return $who_pre.$accept.$canсell;
            case "completed":
                $editlink = route('object.edit',['object'=>$object->alias]);
                $acceptlink = route('object.activate',['object'=>$object->alias]);
                $deletelink = route('object.softDelete',['object'=>$object->alias]);
                $edit = "<a class='btn btn-secondary btn-sm' href='$editlink' data-toggle=\"tooltip\" data-placement=\"bottom\" title='Редактировать'><i class=\"fa fa-edit fa-lg\"></i></a>";
                $accept = "<form action='$acceptlink' method='post'><input type=\"hidden\" name=\"_method\" value=\"PUT\"><input type=\"hidden\" name=\"_token\" value=\"".csrf_token()."\"><button class='btn btn-secondary btn-sm' type='submit' data-toggle=\"tooltip\" data-placement=\"bottom\" title='Активировать'><i class=\"fa fa-bell fa-lg\"></i></button></form>";
                $delete = "<form action='$deletelink' method='post'><input type=\"hidden\" name=\"_method\" value=\"DELETE\"><input type=\"hidden\" name=\"_token\" value=\"".csrf_token()."\"><button class='btn btn-secondary btn-sm' type='submit' data-toggle=\"tooltip\" data-placement=\"bottom\" title='Удалить'><i class=\"fa fa-trash fa-lg\"></i></button></form>";
                return $edit.$accept.$delete;
            case "deleted":
                $who = $object->deletedUser->name;
                $acceptlink = route('object.destroy',['object'=>$object->alias]);
                $restorelink = route('object.restore',['object'=>$object->alias]);
                $who_delete = "<p style='color: #BABABA'>От ".$who."</p>";
                $accept = "<form action='$acceptlink' method='post'><input type=\"hidden\" name=\"_method\" value=\"DELETE\"><input type=\"hidden\" name=\"_token\" value=\"".csrf_token()."\"><button class='btn btn-secondary btn-sm' type='submit' data-toggle=\"tooltip\" data-placement=\"bottom\" title='Удалить навсегда'><i class=\"fa fa-trash fa-lg\"></i></button></form>";
                $restore = "<form action='$restorelink' method='post'><input type=\"hidden\" name=\"_method\" value=\"PUT\"><input type=\"hidden\" name=\"_token\" value=\"".csrf_token()."\"><button class='btn btn-secondary btn-sm' type='submit' data-toggle=\"tooltip\" data-placement=\"bottom\" title='Восстановить'><i class=\"fa fa-reply fa-lg\"></i></button></form>";
                return $who_delete.$accept.$restore;
            default:
                if ($user->role->name != "user") {
                    $editlink = route('object.edit',['object'=>$object->alias]);
                    $worklink = route('object.prework',['object'=>$object->alias]);
                    if ($object->preworkingUser != null || $object->workingUser != null) {
                        $inwork = "<button type=\"button\" class=\"btn btn-secondary btn-sm disabled\"><i class=\"fa fa-gears fa-lg\"></i></button>";
                    } else {
                        $inwork = "<form action='$worklink' method='post'><input type=\"hidden\" name=\"_method\" value=\"PUT\"><input type=\"hidden\" name=\"_token\" value=\"".csrf_token()."\"><button class='btn btn-secondary btn-sm' type='submit' data-toggle=\"tooltip\" data-placement=\"bottom\" title='Взять в работу'><i class=\"fa fa-gears fa-lg\"></i></button></form>";
                    }
                    $deletelink = route('object.softDelete',['object'=>$object->alias]);
                    if($object->workingUser == null || $user->role->name == "admin")  {
                        $delete = "<form action='$deletelink' method='post'><input type=\"hidden\" name=\"_method\" value=\"DELETE\"><input type=\"hidden\" name=\"_token\" value=\"".csrf_token()."\"><button class='btn btn-secondary btn-sm' type='submit' data-toggle=\"tooltip\" data-placement=\"bottom\" title='Удалить'><i class=\"fa fa-trash fa-lg\"></i></button></form>";
                        $edit = "<a class='btn btn-secondary btn-sm' href='$editlink' data-toggle=\"tooltip\" data-placement=\"bottom\" title='Редактировать'><i class=\"fa fa-edit fa-lg\"></i></a>";
                    } else {
                        if(($object->workingUser->id == $user->id) || $user->role->name == "admin") {
                            $delete = "<form action='$deletelink' method='post'><input type=\"hidden\" name=\"_method\" value=\"DELETE\"><input type=\"hidden\" name=\"_token\" value=\"".csrf_token()."\"><button class='btn btn-secondary btn-sm' type='submit' data-toggle=\"tooltip\" data-placement=\"bottom\" title='Удалить'><i class=\"fa fa-trash fa-lg\"></i></button></form>";
                            $edit = "<a class='btn btn-secondary btn-sm' href='$editlink' data-toggle=\"tooltip\" data-placement=\"bottom\" title='Редактировать'><i class=\"fa fa-edit fa-lg\"></i></a>";
                        } else {
                            $delete = "<button type=\"button\" class=\"btn btn-secondary btn-sm disabled\"><i class=\"fa fa-trash fa-lg disabled\"></i></button>";
                            $edit = "<button type=\"button\" class=\"btn btn-secondary btn-sm disabled\"><i class=\"fa fa-edit fa-lg disabled\"></i></button>";
                        }
                    }

                } else {
                    $editlink = route('object.edit',['object'=>$object->alias]);
                    $inwork = "<button type=\"button\" class=\"btn btn-secondary btn-sm disabled\"><i class=\"fa fa-gears fa-lg disabled\"></i></button>";
                    $deletelink = route('object.softDelete',['object'=>$object->alias]);
                    $delete = "<form action='$deletelink' method='post'><input type=\"hidden\" name=\"_method\" value=\"DELETE\"><input type=\"hidden\" name=\"_token\" value=\"".csrf_token()."\"><button class='btn btn-secondary btn-sm' type='submit' data-toggle=\"tooltip\" data-placement=\"bottom\" title='Удалить'><i class=\"fa fa-trash fa-lg\"></i></button></form>";
                    $edit = "<a class='btn btn-secondary btn-sm' href='$editlink' data-toggle=\"tooltip\" data-placement=\"bottom\" title='Редактировать'><i class=\"fa fa-edit fa-lg\"></i></a>";
                }
                $favoriteslink = route('object.favorite',['object'=>$object->alias]);
                $favor_ = $this->checkFavorite($object);
                $favor_type = $favor_ ? "delete" : "add";
                $favorites = "<form class='favor' action='$favoriteslink' method='post'><input type=\"hidden\" name=\"_method\" value=\"PUT\"><input type=\"hidden\" name=\"_token\" value=\"".csrf_token()."\"><input type=\"hidden\" name=\"type\" value=\"$favor_type\"><button class='btn btn-secondary btn-sm btn-favor' type='submit' data-toggle=\"tooltip\" data-placement=\"bottom\" title='В избранное'><i id='favor-".$object->id."' class=\"fa " . ($favor_ ? "fa-star" : "fa-star-o") . " fa-lg\"></i></button></form>";
                return $edit.$inwork.$favorites.$delete;
        }
    }

    private function checkFavorite($object) {
        $favorites = $this->user->favorites()->get();
        foreach ($favorites as $favorite) {
            if($favorite->id == $object->id) {
                return true;
            }
        }
        return false;
    }

    private function checkAFavorite($object) {
        $favorites = $this->user->a_favorites()->get();
        foreach ($favorites as $favorite) {
            if($favorite->id == $object->id) {
                return true;
            }
        }
        return false;
    }

    public function getAobjActions($aobject) {
        $deletelink = route('aobject.delete',['aobject'=>$aobject->id]);
        $transferlink = route('aobject.transfer',['aobject'=>$aobject->id]);
        $transfer = "<a class='btn btn-secondary btn-sm' href='$transferlink' data-toggle=\"tooltip\" data-placement=\"bottom\" title='Перенести'><i class=\"fa fa-edit fa-lg\"></i></a>";
        $delete = "<form action='$deletelink' method='post'><input type=\"hidden\" name=\"_method\" value=\"DELETE\"><input type=\"hidden\" name=\"_token\" value=\"".csrf_token()."\"><button class='btn btn-secondary btn-sm' type='submit' data-toggle=\"tooltip\" data-placement=\"bottom\" title='Удалить'><i class=\"fa fa-trash fa-lg\"></i></button></form>";
        $favor_ = $this->checkAFavorite($aobject);
        $favoriteslink = route('aobject.favorite',['aobject'=>$aobject->id]);
        $favor_type = $favor_ ? "delete" : "add";
        $favorite = "<form class='favor' action='$favoriteslink' method='post'><input type=\"hidden\" name=\"_method\" value=\"PUT\"><input type=\"hidden\" name=\"_token\" value=\"".csrf_token()."\"><input type=\"hidden\" name=\"type\" value=\"$favor_type\"><button class='btn btn-secondary btn-sm btn-favor' type='submit' data-toggle=\"tooltip\" data-placement=\"bottom\" title='В избранное'><i id='favor-".$aobject->id."' class=\"fa " . ($favor_ ? "fa-star" : "fa-star-o") . " fa-lg\"></i></button></form>";
        return $transfer.$delete.$favorite;
    }
}
