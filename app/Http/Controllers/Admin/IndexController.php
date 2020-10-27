<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Repositories\ObjectsRepository;
use App\Repositories\CitiesRepository;
use App\Repositories\AreasRepository;
use App\Repositories\AobjectsRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Components\JavaScriptMaker;
use Excel;
use Menu;
use Gate;
use URL;
use Route;
use Storage;

class IndexController extends AdminController {

    protected $o_rep;
    protected $city_rep;
    protected $area_rep;

    public function __construct(ObjectsRepository $o_rep, CitiesRepository $city_rep, AreasRepository $area_rep, AobjectsRepository $aobj_rep) {
       parent::__construct(new \App\Repositories\AdmMenusRepository(new \App\AdmMenu), new \App\Repositories\SettingsRepository(new \App\Setting()), new \App\Repositories\AobjectsRepository(new \App\Aobject()), new \App\User);

//        if(Gate::denies('VIEW_ADMIN')) {
//            abort(403);
//        }
        
        $this->inc_css_lib = array_add($this->inc_css_lib,  'adm-filter', array('url' => '<link rel="stylesheet" href="'.$this->pub_path.'/css/adm.filter.css">'));
        $this->inc_css_lib = array_add($this->inc_css_lib,  'jq-ui', array('url' => '<link rel="stylesheet" href="'.$this->pub_path.'/css/lib/jqueryui/jquery-ui.min.css">'));
        $this->inc_js_lib = array_add($this->inc_js_lib,'jq-ui',array('url' => '<script src="'.$this->pub_path.'/js/lib/jqueryui/jquery-ui.min.js"></script>'));
        $this->inc_js_lib = array_add($this->inc_js_lib,    'leaflet', array('url' => '<script src="'.$this->pub_path.'/leaflet/leaflet.js"></script>'));
        $this->inc_js_lib = array_add($this->inc_js_lib,    'leaflet-cluster', array('url' => '<script src="'.$this->pub_path.'/leaflet/leaflet.markercluster-src.js"></script>'));
        $this->template = config('settings.theme').'.admin.index';
        $this->o_rep = $o_rep;
        $this->aobj_rep = $aobj_rep;
        $this->city_rep = $city_rep;
        $this->area_rep = $area_rep;
        // INIT INPUTS
        $this->inputs = array_add($this->inputs, "obj_category", array("1" => "Квартира", "2" => "Дом, Дача, Таунхаус", "3" => "Комната"));
        $this->inputs = array_add($this->inputs, "obj_deal", array("" => "Тип сделки","Продажа" => "Продажа", "Обмен" => "Обмен"));
        $this->inputs = array_add($this->inputs, "obj_form_1", array("Вторичка" => "Вторичка", "Новостройка" => "Новостройка"));
        $this->inputs = array_add($this->inputs, "obj_form_2", array("Дом" => "Дом", "Дача" => "Дача", "Коттедж" => "Коттедж", "Таунхаус" => "Таунхаус"));
        $this->inputs = array_add($this->inputs, "obj_form_3", array("" => "Тип объекта","Гостиничного" => "Гостиничного", "Коридорного" => "Коридорного", "Секционного" => "Секционного", "Коммунальная" => "Коммунальная"));
        $this->inputs = array_add($this->inputs, "obj_room", array("1" => "1", "2" => "2", "3" => "3", "4" => "4", "5" => "5", "6" => "6", "7" => "7", "8" => "8", "9" => "9", "10" => "9+"));
        $this->inputs = array_add($this->inputs, "obj_home_floors_2", array("1" => "1", "2" => "2", "3" => "3", "4" => "4", "5" => "5+"));
        $this->inputs = array_add($this->inputs, "obj_build_type_1", array("Кирпичный" => "Кирпичный", "Панельный" => "Панельный", "Блочный" => "Блочный", "Монолитный" => "Монолитный", "Деревянный" => "Деревянный"));
        $this->inputs = array_add($this->inputs, "obj_build_type_2", array("Кирпич" => "Кирпич", "Брус" => "Брус", "Бревно" => "Бревно", "Металл" => "Металл", "Пеноблоки" => "Пеноблоки", "Сэндвич-панели" => "Сэндвич-панели", "Ж/б панели" => "Ж/б панели", "Экспериментальные материалы" => "Экспериментальные материалы"));
        $this->inputs = array_add($this->inputs, "obj_floor", array("1" => "1", "2" => "2", "3" => "3", "4" => "4", "5" => "5", "6" => "6", "7" => "7", "8" => "8", "9" => "9", "10" => "10", "11" => "11", "12" => "12", "13" => "13", "14" => "14", "15" => "15", "16" => "16", "17" => "17", "18" => "18", "19" => "19", "20" => "20"));
        $this->inputs = array_add($this->inputs, "obj_distance", array("0" => "В черте города", "10" => "10 км", "20" => "20 км", "30" => "30 км", "50" => "50 км", "70" => "70+ км"));
        $this->inputs = array_add($this->inputs, "obj_home_floors_1", array("1" => "1", "2" => "2", "3" => "3", "4" => "4", "5" => "5", "6" => "6", "7" => "7", "8" => "8", "9" => "9", "10" => "10", "11" => "11", "12" => "12", "13" => "13", "14" => "14", "15" => "15", "16" => "16", "17" => "17", "18" => "18", "19" => "19", "20" => "20"));
        $this->inputs = array_add($this->inputs, "out", array("avito" => "Avito", "yandex" => "Yandex", "click" => "Click", "all" => "Во все системы"));
    }

    public function index(JavaScriptMaker $jsmaker, Request $request, $type = 'default', $order = ["created_at", "desc"]) {
        $this->checkUser();

//        if (Gate::check('isAdmin', $this->user)) {
//            abort(403);
//        }
        $cities = $this->city_rep->get();
        $obj_city = array();
        $obj_city = array_add($obj_city, "", "По всем городам");
        foreach ($cities as $city) {
            $obj_city = array_add($obj_city, $city->id, $city->name );
        }
        $this->inputs = array_add($this->inputs, "cities", $obj_city);
        $objects = $this->o_rep->getScope($type, $request, false, $order, $this->settings["pagination"]);
        $objects->appends(request()->input());
        $actions = array();
        $mass_actions = $this->getMassActions($type);
        foreach ($objects as $object) {
            $actions = array_add($actions,"object".$object->id, $this->getActions($object, $this->user, $type));
            $object->client = json_decode($object->client);
        }
        $orders = array("created_at" => "По дате", "price" => "Дешевле", "pricedesc" => "Дороже");
        $order_select = array();
        $selected = Url::current();
        foreach ($orders as $key => $value) {
            $rq = request()->input();
            $rq["order"] = $key;
            $rq["type"] = $type;
            $link = route(Route::current()->getName(), $rq);
            $order_select[$link] = $value;
            if($request->route("order") && $order == $key) {
                $selected = $link;
            }
        }
        $menus = $this->getObjectsMenu();
        if ($request->has("search")) {
            $jsmaker->setJs("filter", $request, false, "", $this->randStr);
            $filter_data = $this->getFilterData($request->except("search"));
            if (!$request->has("page")) {
            Session::flash('search_status', $objects->total());
            }
            
        } else {
            $jsmaker->setJs("filter", "", true, "", $this->randStr);
            $filter_data = $request->except("search");
        }
        $filter = view(config('settings.theme').'.admin.filter')->with(array("inputs" => $this->inputs, "cities" => $cities, "data" => $filter_data));
        $this->content = view(config('settings.theme').'.admin.objects')->with(array("objects" => $objects, "menus" => $menus, "actions" => $actions, "mass_actions" => $mass_actions,"order_select" => $order_select, "type" => $type, "filter" => $filter, "selected" => $selected, "user" => $this->user, "inputs" => $this->inputs))->render();
        $this->title = 'Личный кабинет';
        return $this->renderOutput();
    }

    public function avito(JavaScriptMaker $jsmaker, Request $request, $order = ["date", "desc"]) {
//        $objects = $this->aobj_rep->get("*");
//        foreach ($objects as $object) {
//            $y = (int) $object->created_at->format("Y");
//            if($y == 2017 ) $object->delete();
//        }
        $this->checkUser();
        if($this->user->cant('viewAvito', $this->user)) {
            return back()->with(array('error' => 'Доступ запрещен'));
        }
        $cities = $this->city_rep->get();
        $obj_city = array();
        $obj_city = array_add($obj_city, "", "По всем городам");
        foreach ($cities as $city) {
            $obj_city = array_add($obj_city, $city->id, $city->name );
        }
        $this->inputs = array_add($this->inputs, "cities", $obj_city);
        $orders = array("created_at" => "По дате", "price" => "Дешевле", "pricedesc" => "Дороже");
        $order_select = array();
        $selected = Url::current();
        foreach ($orders as $key => $value) {
            $rq = request()->input();
            $rq["order"] = $key;
            $link = route(Route::current()->getName(), $rq);
            $order_select[$link] = $value;
            if($request->route("order") && $order == $key) {
                $selected = $link;
            }
        }
        if ($request->has("search")) {
            $data = $this->getFilterData($request->except("search"));
            if (isset($data["area" . $data["city"]])) {
                for ($i=0; $i < count($data["area" . $data["city"]]); $i++) {
                    $where = array("id", $data["area" . $data["city"]][0]);
                    $area = $this->area_rep->get("*", false, false, $where);
                    $data["area".$data["city"]][$i] = $area[0]->name;
                }
            }
            //скать по ИД
            $data["city_id"] = $data["city"];
            if ($data["city"] == 1) {
                $data["city"] = "Волгоград";
            } else if($data["city"] == 2) {
                $data["city"] = "Волжский";
            } else if($data["city"] == 3) {
                $data["city"] = "Средняя Ахтуба";
            }
            $objects = $this->aobj_rep->searchObject($data, 40, $order);
            $objects->appends(request()->input());
            $jsmaker->setJs("filter", $request, false, "", $this->randStr);
            if (!$request->has("page")) {
                Session::flash('search_status', $objects->total());
            }
        } else {
            $objects = $this->aobj_rep->get("*", false, 40, false, false, $order);
            $jsmaker->setJs("filter", "", true, "", $this->randStr);
            $data = $request->except("search");
        }
        $actions = array();
        foreach ($objects as $object) {
            //сделать проверочки
            if (isset($object->client_contacts) && strlen($object->client_contacts) > 1 && $object->client_contacts != "none") {
                $phone = preg_replace("/[^,.0-9]/", '', $object->client_contacts);
                if ($phone[0] == 8 || $phone[0] == 7) {
                    $phone = substr( $phone, 1);
                }
                $object->client_contacts = "8" . $phone;
            }
            $actions = array_add($actions,"object".$object->id, $this->getAobjActions($object));
        }
        $filter = view(config('settings.theme').'.admin.filterA')->with(array("inputs" => $this->inputs, "cities" => $cities, "data" => $data));
        $this->content = view(config('settings.theme').'.admin.aobjects')->with(array("objects" => $objects, "type" => "default", "filter" => $filter,"order_select" => $order_select, "selected" => $selected, "actions" => $actions))->render();
        $this->title = 'Обьекты Авито';
        return $this->renderOutput();
    }
    
    private function getObjectsMenu() {
        $menu = $this->m_rep->getMenu("object");
            $mBuilder = Menu::make('objectNav', function($m) use ($menu) {
                foreach($menu as $item) {
                    if($item->parent == 0) {
                        $count = $this->o_rep->getScope($item->alias, false, true);
                        $m->add($item->title,array('url' => route($item->path, ["type" => (($item->alias == "default")? "" : $item->alias)]), 'id' => $item->id))->data(array('icon' => $item->icon,"count" => $count, "type" => $item->alias ));
                    }
                    else {
                        if($m->find($item->parent)) {
                            $m->find($item->parent)->add($item->title,route($item->path , ["type" => $item->alias]))->id($item->id);
                        }
                    }
                }
            });
            return $mBuilder;
    }
    
    private function getFilterData($data) {
        if (isset($data["city"])) {
            if (isset($data["area".$data["city"]])) {
                if ((count($data["area" . $data["city"]]) > 1)) {
                    $data["value_area" . $data["city"]] = "Район (" . count($data["area" . $data["city"]]) . ")";
                } else {
                    $where = array("id", $data["area" . $data["city"]][0]);
                    $area = $this->area_rep->get("*", false, false, $where);
                    $data["value_area" . $data["city"]] = $area[0]->name;
                }
            }
        }
        if (isset($data["room"])) {
            if (count($data["room"]) > 1) {
               $data["value_rooms"] = "Типов кол. комнат (" .count($data["room"]). ")";
            } else {
               $data["value_rooms"] = $data["room"][0]. "-к";
            }
        }
        if (isset($data["typeObj_2"])) {
            if (count($data["typeObj_2"]) > 1) {
                $data["value_typeObj_2"] = "Вид объекта (" .count($data["typeObj_2"]). ")";
            } else {
                $data["value_typeObj_2"] = $data["typeObj_2"][0];
            }
        }
        if (isset($data["typeObj_2"])) {
            if (count($data["typeObj_2"]) > 1) {
                $data["value_typeObj_2"] = "Вид объекта (" .count($data["typeObj_2"]). ")";
            } else {
                $data["value_typeObj_2"] = $data["typeObj_2"][0];
            }
        }
        if (isset($data["typeHouse_2"])) {
            if (count($data["typeHouse_2"]) > 1) {
                $data["value_typeHouse_2"] = "Материал стен (" .count($data["typeHouse_2"]). ")";
            } else {
                $data["value_typeHouse_2"] = $data["typeHouse_2"][0];
            }
        }
        if (isset($data["typeHouse_1"])) {
            if (count($data["typeHouse_1"]) > 1) {
                $data["value_typeHouse_1"] = "Тип Дома (" .count($data["typeHouse_1"]). ")";
            } else {
                $data["value_typeHouse_1"] = $data["typeHouse_1"][0];
            }
        }
        return $data;
    }

    private function getActions($object, $user, $type) {
        switch ($type) {
            case "outed":
                $editlink = route('object.edit',['object'=>$object->alias]);
                $unworklink = route('object.unwork',['object'=>$object->alias]);
                $unoutlink = route('object.unout',['object'=>$object->alias]);
                $uninwork = "<form target='_blank' action='$unworklink' method='post'><input type=\"hidden\" name=\"_method\" value=\"PUT\"><input type=\"hidden\" name=\"_token\" value=\"".csrf_token()."\"><button class='btn btn-secondary btn-sm' type='submit' data-toggle=\"tooltip\" data-placement=\"bottom\" title='Убрать из работы'><i class=\"fa fa-gear fa-lg\"></i></button></form>";
                $deletelink = route('object.softDelete',['object'=>$object->alias]);
                $delete = "<form target='_blank' action='$deletelink' method='post'><input type=\"hidden\" name=\"_method\" value=\"DELETE\"><input type=\"hidden\" name=\"_token\" value=\"".csrf_token()."\"><button class='btn btn-secondary btn-sm' type='submit' data-toggle=\"tooltip\" data-placement=\"bottom\" title='Удалить'><i class=\"fa fa-trash fa-lg\"></i></button></form>";
                $edit = "<a target='_blank' class='btn btn-secondary btn-sm' href='$editlink' data-toggle=\"tooltip\" data-placement=\"bottom\" title='Редактировать'><i class=\"fa fa-edit fa-lg\"></i></a>";
                $unout = "<form target='_blank' action='$unoutlink' method='post'><input type=\"hidden\" name=\"_method\" value=\"DELETE\"><input type=\"hidden\" name=\"_token\" value=\"".csrf_token()."\"><button class='btn btn-secondary btn-sm' type='submit' data-toggle=\"tooltip\" data-placement=\"bottom\" title='Убрать с выгрузки'><i class=\"fa fa-times fa-lg\"></i></button></form>";
                return $edit.$uninwork.$unout.$delete;
            case "myouted":
                $editlink = route('object.edit',['object'=>$object->alias]);
                $unworklink = route('object.unwork',['object'=>$object->alias]);
                $unoutlink = route('object.unout',['object'=>$object->alias]);
                $uninwork = "<form target='_blank' action='$unworklink' method='post'><input type=\"hidden\" name=\"_method\" value=\"PUT\"><input type=\"hidden\" name=\"_token\" value=\"".csrf_token()."\"><button class='btn btn-secondary btn-sm' type='submit' data-toggle=\"tooltip\" data-placement=\"bottom\" title='Убрать из работы'><i class=\"fa fa-gear fa-lg\"></i></button></form>";
                $deletelink = route('object.softDelete',['object'=>$object->alias]);
                $delete = "<form target='_blank' action='$deletelink' method='post'><input type=\"hidden\" name=\"_method\" value=\"DELETE\"><input type=\"hidden\" name=\"_token\" value=\"".csrf_token()."\"><button class='btn btn-secondary btn-sm' type='submit' data-toggle=\"tooltip\" data-placement=\"bottom\" title='Удалить'><i class=\"fa fa-trash fa-lg\"></i></button></form>";
                $edit = "<a class='btn btn-secondary btn-sm' href='$editlink' data-toggle=\"tooltip\" data-placement=\"bottom\" title='Редактировать'><i class=\"fa fa-edit fa-lg\"></i></a>";
                $unout = "<form target='_blank' action='$unoutlink' method='post'><input type=\"hidden\" name=\"_method\" value=\"DELETE\"><input type=\"hidden\" name=\"_token\" value=\"".csrf_token()."\"><button class='btn btn-secondary btn-sm' type='submit' data-toggle=\"tooltip\" data-placement=\"bottom\" title='Убрать с выгрузки'><i class=\"fa fa-times fa-lg\"></i></button></form>";
                return $edit.$uninwork.$unout.$delete;
            case "inwork":
                $editlink = route('object.edit',['object'=>$object->alias]);
                $unworklink = route('object.unwork',['object'=>$object->alias]);
                $outlink = route('object.out',['object'=>$object->alias]);
                $uninwork = "<form target='_blank' action='$unworklink' method='post'><input type=\"hidden\" name=\"_method\" value=\"PUT\"><input type=\"hidden\" name=\"_token\" value=\"".csrf_token()."\"><button class='btn btn-secondary btn-sm' type='submit' data-toggle=\"tooltip\" data-placement=\"bottom\" title='Убрать из работы'><i class=\"fa fa-gear fa-lg\"></i></button></form>";
                $deletelink = route('object.softDelete',['object'=>$object->alias]);
                $delete = "<form target='_blank' action='$deletelink' method='post'><input type=\"hidden\" name=\"_method\" value=\"DELETE\"><input type=\"hidden\" name=\"_token\" value=\"".csrf_token()."\"><button class='btn btn-secondary btn-sm' type='submit' data-toggle=\"tooltip\" data-placement=\"bottom\" title='Удалить'><i class=\"fa fa-trash fa-lg\"></i></button></form>";
                $edit = "<a target='_blank' class='btn btn-secondary btn-sm' href='$editlink' data-toggle=\"tooltip\" data-placement=\"bottom\" title='Редактировать'><i class=\"fa fa-edit fa-lg\"></i></a>";
               // $out = "<form action='$outlink' method='post'><input type=\"hidden\" name=\"_method\" value=\"PUT\"><input type=\"hidden\" name=\"_token\" value=\"".csrf_token()."\"><button class='btn btn-secondary btn-sm' type='submit' data-toggle=\"tooltip\" data-placement=\"bottom\" title='Выгрузить'><i class=\"fa fa-retweet fa-lg\"></i></button></form>";
                $out = "<button target='_blank' class='btn btn-secondary btn-sm out-modal' data-base-url=\"" . route('object.out' , ['object'=>'']) . "\" data-alias=\"$object->alias\" data-toggle=\"modal\" data-target=\".modal-out\" data-placement=\"bottom\" title='Выгрузить'>
                        <i class=\"fa fa-retweet fa-lg\"></i></button>";

                return $edit.$uninwork.$out.$delete;
            case "prework":
                $editlink = route('object.edit',['object'=>$object->alias]);
                $unworklink = route('object.unwork',['object'=>$object->alias]);
                $outlink = route('object.out',['object'=>$object->alias]);
                $uninwork = "<form target='_blank' action='$unworklink' method='post'><input type=\"hidden\" name=\"_method\" value=\"PUT\"><input type=\"hidden\" name=\"_token\" value=\"".csrf_token()."\"><button class='btn btn-secondary btn-sm' type='submit' data-toggle=\"tooltip\" data-placement=\"bottom\" title='Убрать из работы'><i class=\"fa fa-gear fa-lg\"></i></button></form>";
                $deletelink = route('object.softDelete',['object'=>$object->alias]);
                $delete = "<form target='_blank' action='$deletelink' method='post'><input type=\"hidden\" name=\"_method\" value=\"DELETE\"><input type=\"hidden\" name=\"_token\" value=\"".csrf_token()."\"><button class='btn btn-secondary btn-sm' type='submit' data-toggle=\"tooltip\" data-placement=\"bottom\" title='Удалить'><i class=\"fa fa-trash fa-lg\"></i></button></form>";
                $edit = "<a target='_blank' class='btn btn-secondary btn-sm' href='$editlink' data-toggle=\"tooltip\" data-placement=\"bottom\" title='Редактировать'><i class=\"fa fa-edit fa-lg\"></i></a>";
                //$out = "<form action='$outlink' method='post'><input type=\"hidden\" name=\"_method\" value=\"PUT\"><input type=\"hidden\" name=\"_token\" value=\"".csrf_token()."\"><button class='btn btn-secondary btn-sm' type='submit' data-toggle=\"tooltip\" data-placement=\"bottom\" title='Выгрузить'><i class=\"fa fa-retweet fa-lg\"></i></button></form>";
                $out = "<button target='_blank' class='btn btn-secondary btn-sm out-modal' data-base-url=\"" . route('object.out' , ['object'=>'']) . "\" data-alias=\"$object->alias\" data-toggle=\"modal\" data-target=\".modal-out\" data-placement=\"bottom\" title='Выгрузить'>
                        <i class=\"fa fa-retweet fa-lg\"></i></button>";
                return $edit.$uninwork.$out.$delete;
//                $who = $object->preworkingUser->name;
//                $acceptlink = route('object.accessPreWork',['object'=>$object->alias]);
//                $canсelllink = route('object.cancelPreWork',['object'=>$object->alias]);
//                $who_pre = "<p style='color: #BABABA; margin:0 !important;'>От ".$who."</p>";
//                $accept = "<form action='$acceptlink' method='post'><input type=\"hidden\" name=\"_method\" value=\"PUT\"><input type=\"hidden\" name=\"_token\" value=\"".csrf_token()."\"><button class='btn btn-secondary btn-sm' type='submit' data-toggle=\"tooltip\" data-placement=\"bottom\" title='Подтвердить'><i class=\"fa fa-check fa-lg\"></i></button></form>";
//                $canсell = "<form action='$canсelllink' method='post'><input type=\"hidden\" name=\"_method\" value=\"PUT\"><input type=\"hidden\" name=\"_token\" value=\"".csrf_token()."\"><button class='btn btn-secondary btn-sm' type='submit' data-toggle=\"tooltip\" data-placement=\"bottom\" title='Отклонить'><i class=\"fa fa-ban fa-lg\"></i></button></form>";
//                return $who_pre.$accept.$canсell;
            case "completed":
                $editlink = route('object.edit',['object'=>$object->alias]);
                $acceptlink = route('object.activate',['object'=>$object->alias]);
                $deletelink = route('object.softDelete',['object'=>$object->alias]);
                $edit = "<a target='_blank' class='btn btn-secondary btn-sm' href='$editlink' data-toggle=\"tooltip\" data-placement=\"bottom\" title='Редактировать'><i class=\"fa fa-edit fa-lg\"></i></a>";
                $accept = "<form target='_blank' action='$acceptlink' method='post'><input type=\"hidden\" name=\"_method\" value=\"PUT\"><input type=\"hidden\" name=\"_token\" value=\"".csrf_token()."\"><button class='btn btn-secondary btn-sm' type='submit' data-toggle=\"tooltip\" data-placement=\"bottom\" title='Активировать'><i class=\"fa fa-bell fa-lg\"></i></button></form>";
                $delete = "<form target='_blank' action='$deletelink' method='post'><input type=\"hidden\" name=\"_method\" value=\"DELETE\"><input type=\"hidden\" name=\"_token\" value=\"".csrf_token()."\"><button class='btn btn-secondary btn-sm' type='submit' data-toggle=\"tooltip\" data-placement=\"bottom\" title='Удалить'><i class=\"fa fa-trash fa-lg\"></i></button></form>";
                return $edit.$accept.$delete;
            case "deleted":
                $who = $object->deletedUser->name ?? "";
                $acceptlink = route('object.destroy',['object'=>$object->alias]);
                $restorelink = route('object.restore',['object'=>$object->alias]);
                $who_delete = "<p style='color: #BABABA; margin:0 !important;'>От ".$who."</p>";
                $accept = "<form target='_blank' action='$acceptlink' method='post'><input type=\"hidden\" name=\"_method\" value=\"DELETE\"><input type=\"hidden\" name=\"_token\" value=\"".csrf_token()."\"><button class='btn btn-secondary btn-sm' type='submit' data-toggle=\"tooltip\" data-placement=\"bottom\" title='Удалить навсегда'><i class=\"fa fa-trash fa-lg\"></i></button></form>";
                $restore = "<form target='_blank' action='$restorelink' method='post'><input type=\"hidden\" name=\"_method\" value=\"PUT\"><input type=\"hidden\" name=\"_token\" value=\"".csrf_token()."\"><button class='btn btn-secondary btn-sm' type='submit' data-toggle=\"tooltip\" data-placement=\"bottom\" title='Восстановить'><i class=\"fa fa-reply fa-lg\"></i></button></form>";
                return $who_delete.$accept.$restore;
            default:
                if ($user->role->name != "user") {
                    $editlink = route('object.edit',['object'=>$object->alias]);
                    $worklink = route('object.prework',['object'=>$object->alias]);
                    if ($object->preworkingUser != null || $object->workingUser != null) {
                        $inwork = "<button type=\"button\" class=\"btn btn-secondary btn-sm disabled\"><i class=\"fa fa-gears fa-lg\"></i></button>";
                    } else {
                        $inwork = "<form target='_blank' action='$worklink' method='post'><input type=\"hidden\" name=\"_method\" value=\"PUT\"><input type=\"hidden\" name=\"_token\" value=\"".csrf_token()."\"><button class='btn btn-secondary btn-sm' type='submit' data-toggle=\"tooltip\" data-placement=\"bottom\" title='Взять в работу'><i class=\"fa fa-gears fa-lg\"></i></button></form>";
                    }
                    $deletelink = route('object.softDelete',['object'=>$object->alias]);
                    if($object->workingUser == null || $user->role->name == "admin")  {
                        $delete = "<form target='_blank' action='$deletelink' method='post'><input type=\"hidden\" name=\"_method\" value=\"DELETE\"><input type=\"hidden\" name=\"_token\" value=\"".csrf_token()."\"><button class='btn btn-secondary btn-sm' type='submit' data-toggle=\"tooltip\" data-placement=\"bottom\" title='Удалить'><i class=\"fa fa-trash fa-lg\"></i></button></form>";
                        $edit = "<a target='_blank' class='btn btn-secondary btn-sm' href='$editlink' data-toggle=\"tooltip\" data-placement=\"bottom\" title='Редактировать'><i class=\"fa fa-edit fa-lg\"></i></a>";
                    } else {
                        if(($object->workingUser->id == $user->id) || $user->role->name == "admin") {
                            $delete = "<form target='_blank' action='$deletelink' method='post'><input type=\"hidden\" name=\"_method\" value=\"DELETE\"><input type=\"hidden\" name=\"_token\" value=\"".csrf_token()."\"><button class='btn btn-secondary btn-sm' type='submit' data-toggle=\"tooltip\" data-placement=\"bottom\" title='Удалить'><i class=\"fa fa-trash fa-lg\"></i></button></form>";
                            $edit = "<a target='_blank' class='btn btn-secondary btn-sm' href='$editlink' data-toggle=\"tooltip\" data-placement=\"bottom\" title='Редактировать'><i class=\"fa fa-edit fa-lg\"></i></a>";
                        } else {
                            $delete = "<button type=\"button\" class=\"btn btn-secondary btn-sm disabled\"><i class=\"fa fa-trash fa-lg disabled\"></i></button>";
                            $edit = "<button type=\"button\" class=\"btn btn-secondary btn-sm disabled\"><i class=\"fa fa-edit fa-lg disabled\"></i></button>";
                        }
                    }

                } else {
                    $editlink = route('object.edit',['object'=>$object->alias]);
                    $inwork = "<button type=\"button\" class=\"btn btn-secondary btn-sm disabled\"><i class=\"fa fa-gears fa-lg disabled\"></i></button>";
                    $deletelink = route('object.softDelete',['object'=>$object->alias]);
                    $delete = "<form target='_blank' action='$deletelink' method='post'><input type=\"hidden\" name=\"_method\" value=\"DELETE\"><input type=\"hidden\" name=\"_token\" value=\"".csrf_token()."\"><button class='btn btn-secondary btn-sm' type='submit' data-toggle=\"tooltip\" data-placement=\"bottom\" title='Удалить'><i class=\"fa fa-trash fa-lg\"></i></button></form>";
                    $edit = "<a target='_blank' class='btn btn-secondary btn-sm' href='$editlink' data-toggle=\"tooltip\" data-placement=\"bottom\" title='Редактировать'><i class=\"fa fa-edit fa-lg\"></i></a>";
                }
                $favoriteslink = route('object.favorite',['object'=>$object->alias]);
                $favor_ = $this->checkFavorite($object);
                $favor_type = $favor_ ? "delete" : "add";
                $favorites = "<form class='favor' action='$favoriteslink' method='post'><input type=\"hidden\" name=\"_method\" value=\"PUT\"><input type=\"hidden\" name=\"_token\" value=\"".csrf_token()."\"><input type=\"hidden\" name=\"type\" value=\"$favor_type\"><button class='btn btn-secondary btn-sm btn-favor' type='submit' data-toggle=\"tooltip\" data-placement=\"bottom\" title='В избранное'><i id='favor-".$object->id."' class=\"fa " . ($favor_ ? "fa-star" : "fa-star-o") . " fa-lg\"></i></button></form>";
                return $edit.$inwork.$favorites.$delete;
        }
    }

    private function getMassActions($type) {
        switch ($type) {
            case "my":
                $actions = ["" => "Действие", "delete" => "Удалить", "inwork" => "Взять в работу"];
                break;
            case "inwork":
                $actions = ["" => "Действие", "delete" => "Удалить", "unwork" => "Убрать из работы", "out" => "Выгрузить"];
                break;
            case "prework":
//                $actions = ["" => "Действие", "accept_prework" => "Подтвердить", "cancel_prework" => "Отклонить"];
                $actions = ["" => "Действие", "delete" => "Удалить", "unwork" => "Убрать из работы", "out" => "Выгрузить"];
                break;
            case "completed":
                $actions = ["" => "Действие", "activate" => "Активировать", "delete" => "Удалить"];
                break;
            case "outed":
                $actions = ["" => "Действие", "delete" => "Удалить", "unwork" => "Убрать из работы", "unout" => "Убрать с выгрузки"];
                break;
            case "myouted":
                $actions = ["" => "Действие", "delete" => "Удалить", "unwork" => "Убрать из работы", "unout" => "Убрать с выгрузки"];
                break;
            case "deleted":
                $actions = ["" => "Действие", "destroy" => "Удалить на всегда", "recover" => "Восстановить"];
                break;
            default:
                $actions = ["" => "Действие", "delete" => "Удалить", "inwork" => "Взять в работу"];
                break;
        }
        return $actions;
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
        $transfer = "<a target='_blank' class='btn btn-secondary btn-sm' href='$transferlink' data-toggle=\"tooltip\" data-placement=\"bottom\" title='Перенести'><i class=\"fa fa-edit fa-lg\"></i></a>";
        $delete = "<form action='$deletelink' method='post'><input type=\"hidden\" name=\"_method\" value=\"DELETE\"><input type=\"hidden\" name=\"_token\" value=\"".csrf_token()."\"><button class='btn btn-secondary btn-sm' type='submit' data-toggle=\"tooltip\" data-placement=\"bottom\" title='Удалить'><i class=\"fa fa-trash fa-lg\"></i></button></form>";
        $favor_ = $this->checkAFavorite($aobject);
        $favoriteslink = route('aobject.favorite',['aobject'=>$aobject->id]);
        $favor_type = $favor_ ? "delete" : "add";
        $favorite = "<form class='favor' action='$favoriteslink' method='post'><input type=\"hidden\" name=\"_method\" value=\"PUT\"><input type=\"hidden\" name=\"_token\" value=\"".csrf_token()."\"><input type=\"hidden\" name=\"type\" value=\"$favor_type\"><button class='btn btn-secondary btn-sm btn-favor' type='submit' data-toggle=\"tooltip\" data-placement=\"bottom\" title='В избранное'><i id='favor-".$aobject->id."' class=\"fa " . ($favor_ ? "fa-star" : "fa-star-o") . " fa-lg\"></i></button></form>";
        return $transfer.$delete.$favorite;
    }
}
