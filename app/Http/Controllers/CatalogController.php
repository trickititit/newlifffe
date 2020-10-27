<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Object;
use App\Repositories\ObjectsRepository;
use App\Repositories\CitiesRepository;
use App\Repositories\AreasRepository;
use Illuminate\Support\Facades\Session;
use App\Components\JavaScriptMaker;
use Menu;
use Gate;
use URL;
use Route;

class CatalogController extends SiteController
{
    protected $o_rep;
    protected $city_rep;
    protected $area_rep;

    public function __construct(ObjectsRepository $o_rep, CitiesRepository $city_rep, AreasRepository $area_rep) {
        parent::__construct(new \App\Repositories\AdmMenusRepository(new \App\AdmMenu), new \App\Repositories\SettingsRepository(new \App\Setting), new \App\Object);

//        if(Gate::denies('VIEW_ADMIN')) {
//            abort(403);
//        }
        $this->inc_css_lib = array_add($this->inc_css_lib,  'cat-filter', array('url' => '<link rel="stylesheet" href="'.$this->pub_path.'/css/site.filter.css">'));
        $this->inc_css_lib = array_add($this->inc_css_lib,  'bx-slider', array('url' => '<link rel="stylesheet" href="'.$this->pub_path.'/css/jquery.bxslider.css">'));
        $this->inc_css_lib = array_add($this->inc_css_lib,  'jq-ui', array('url' => '<link rel="stylesheet" href="'.$this->pub_path.'/css/lib/jqueryui/jquery-ui.min.css">'));
        $this->inc_js_lib = array_add($this->inc_js_lib,'jq-ui',array('url' => '<script src="'.$this->pub_path.'/js/lib/jqueryui/jquery-ui.min.js"></script>'));
        $this->inc_css_lib = array_add($this->inc_css_lib,  'modernizr', array('url' => '<script src="'.$this->pub_path.'/js/modernizr.custom.28468.js"></script>'));
        $this->inc_js_lib = array_add($this->inc_js_lib,    'bx-slider', array('url' => '<script src="'.$this->pub_path.'/js/jquery.bxslider.min.js"></script>'));
        $this->inc_js_lib = array_add($this->inc_js_lib,    'cs-slider', array('url' => '<script src="'.$this->pub_path.'/js/jquery.cslider.js"></script>'));
        $this->template = config('settings.theme').'.index';
        $this->o_rep = $o_rep;
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

    }

    public function index(JavaScriptMaker $jsmaker, Request $request, $order = "created_at") {
        $this->title = "Агенство недвижимости Новая Жизнь";
        $cities = $this->city_rep->get();
        $obj_city = array();
        $obj_city = array_add($obj_city, "", "По всем городам");
        foreach ($cities as $city) {
            $obj_city = array_add($obj_city, $city->id, $city->name );
        }
        $this->inputs = array_add($this->inputs, "cities", $obj_city);
        $objects = $this->o_rep->getScope("default", $request, false, $order, 50);

        foreach ($objects as $object) {
//            $object->client = json_decode($object->client);
        }
        $link = route(Route::current()->getName(), ['order' => ""])."";
        $order_select = array($link."/created_at" => "По дате", $link."/price" => "Дешевле", $link."/pricedesc" => "Дороже");
        if ($request->has("search")) {
            $jsmaker->setJs("catalog-filter", $request, false, "", $this->randStr, ($this->spec_offer_count > 5)? true : false);
            $filter_data = $this->getFilterData($request->except("search"));
            Session::flash('search_status', count($objects));
        } else {
            $jsmaker->setJs("catalog-filter", "", true, "", $this->randStr, ($this->spec_offer_count > 5)? true : false);
            $filter_data = $request->except("search");
        }
        $filter = view(config('settings.theme').'.filter')->with(array("inputs" => $this->inputs, "cities" => $cities, "data" => $filter_data));
        $this->content = view(config('settings.theme').'.catalog')->with(array("objects" => $objects, "order_select" => $order_select, "filter" => $filter));
        return $this->renderOutput();
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
}
