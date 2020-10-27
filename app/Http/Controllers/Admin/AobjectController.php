<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ObjectRequest;
use App\Object;
use App\Aobject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\ObjectsRepository;
use App\Repositories\CitiesRepository;
use App\Repositories\AreasRepository;
use App\Repositories\ComfortsRepository;
use App\Components\JavaScriptMaker;
use App\Components\ExcelExport;
use Gate;
use Carbon\Carbon;

class AobjectController extends AdminController
{
   	public $o_rep;
    public $city_rep;
    public $area_rep;
    public $com_rep;

    public function __construct(ObjectsRepository $o_rep, CitiesRepository $city_rep, AreasRepository $area_rep, ComfortsRepository $com_rep) {
       parent::__construct(new \App\Repositories\AdmMenusRepository(new \App\AdmMenu), new \App\Repositories\SettingsRepository(new \App\Setting()), new \App\Repositories\AobjectsRepository(new \App\Aobject()), new \App\User);

//        if(Gate::denies('VIEW_ADMIN')) {
//            abort(403);
//        }
        $this->template = config('settings.theme').'.admin.index';
        $this->o_rep = $o_rep;
        $this->city_rep = $city_rep;
        $this->area_rep = $area_rep;
        $this->com_rep = $com_rep;
        $this->inc_css_lib = array_add($this->inc_css_lib,'dropzone', array('url' => '<link rel="stylesheet" href="'.$this->pub_path.'/css/dropzone.css">'));
        $this->inc_css_lib = array_add($this->inc_css_lib,'jq-steps', array('url' => '<link rel="stylesheet" href="'.$this->pub_path.'/css/separate/vendor/jquery-steps.min.css">'));
        $this->inc_css_lib = array_add($this->inc_css_lib,'multi-org', array('url' => '<link rel="stylesheet" href="'.$this->pub_path.'/css/lib/multipicker/multipicker.min.css">'));
        $this->inc_css_lib = array_add($this->inc_css_lib,'multi-custom', array('url' => '<link rel="stylesheet" href="'.$this->pub_path.'/css/separate/vendor/multipicker.min.css">'));
        $this->inc_css_lib = array_add($this->inc_css_lib,'chosen', array('url' => '<link rel="stylesheet" href="'.$this->pub_path.'/css/chosen.min.css">'));
        $this->inc_js_lib = array_add($this->inc_js_lib,'dropzone',array('url' => '<script src="'.$this->pub_path.'/js/dropzone.js"></script>'));
        $this->inc_js_lib = array_add($this->inc_js_lib,'jq-validate', array('url' => '<script src="'.$this->pub_path.'/js/lib/jquery-validation/jquery.validate.min.js"></script>'));
        $this->inc_js_lib = array_add($this->inc_js_lib,'jq-steps', array('url' => '<script src="'.$this->pub_path.'/js/lib/jquery-steps/jquery.steps.min.js"></script>'));
        //$this->inc_js_lib = array_add($this->inc_js_lib, 'y-maps', array('url' => '<script src="//api-maps.yandex.ru/2.0/?lang=ru-RU&load=package.full"></script>'));
        $this->inc_js_lib = array_add($this->inc_js_lib, 'multipicker', array('url' => '<script src="'.$this->pub_path.'/js/lib/multipicker/multipicker.min.js"></script>'));
        $this->inc_js_lib = array_add($this->inc_js_lib, 'jq-input-mask', array('url' => '<script src="'.$this->pub_path.'/js/lib/input-mask/jquery.mask.min.js"></script>'));
        $this->inc_js_lib = array_add($this->inc_js_lib, 'init-input-mask', array('url' => '<script src="'.$this->pub_path.'/js/lib/input-mask/input-mask-init.js"></script>'));
        $this->inc_js_lib = array_add($this->inc_js_lib, 'chosen', array('url' => '<script src="'.$this->pub_path.'/js/chosen.jquery.min.js"></script>'));
        $this->inc_js_lib = array_add($this->inc_js_lib, 'here', array('url' => '<script src="https://js.api.here.com/v3/3.1/mapsjs-core.js"></script>'));
        $this->inc_js_lib = array_add($this->inc_js_lib, 'here2', array('url' => '<script src="https://js.api.here.com/v3/3.1/mapsjs-service.js"></script>'));
        $this->inc_js_lib = array_add($this->inc_js_lib, 'here3', array('url' => '<script src="https://js.api.here.com/v3/3.1/mapsjs-ui.js"></script>'));
        $this->inc_js_lib = array_add($this->inc_js_lib, 'here4', array('url' => '<script src="https://js.api.here.com/v3/3.1/mapsjs-mapevents.js"></script>'));
        $this->inc_js_lib = array_add($this->inc_js_lib, 'adr_se', array('url' => '<script src="'.$this->pub_path.'/js/search_address.js"></script>'));
        // INIT INPUTS
        $this->inputs = array_add($this->inputs, "obj_type", array("1" => "Квартира", "2" => "Дом, Дача, Таунхаус", "3" => "Комната"));
        $this->inputs = array_add($this->inputs, "client_need", array("1" => "1-к квартира","1x2" => "Две 1-к квартиры", "2" => "2-к квартира", "2x2" => "Две 2-к квартиры", "3" => "3-к квартира", "4-к квартира" => "4-к квартира", "Комната" => "Комната", "Дом" => "Дом", "Дача" => "Дача", "Коттедж" => "Коттедж", "Таунхаус" => "Таунхаус"));
        $this->inputs = array_add($this->inputs, "obj_deal", array("Продажа" => "Продажа", "Обмен" => "Обмен"));
        $this->inputs = array_add($this->inputs, "obj_form_1", array("Вторичка" => "Вторичка", "Новостройка" => "Новостройка"));
        $this->inputs = array_add($this->inputs, "obj_form_2", array("Дом" => "Дом", "Дача" => "Дача", "Коттедж" => "Коттедж", "Таунхаус" => "Таунхаус"));
        $this->inputs = array_add($this->inputs, "obj_form_3", array("Гостиничного" => "Гостиничного", "Коридорного" => "Коридорного", "Секционного" => "Секционного", "Коммунальная" => "Коммунальная"));
        $this->inputs = array_add($this->inputs, "obj_room", array("1" => "1", "2" => "2", "3" => "3", "4" => "4", "5" => "5", "6" => "6", "7" => "7", "8" => "8", "9" => "9", "10" => "9+"));
        $this->inputs = array_add($this->inputs, "obj_home_floors_2", array("1" => "1", "2" => "2", "3" => "3", "4" => "4", "5" => "5+"));
        $this->inputs = array_add($this->inputs, "obj_build_type_1", array("Кирпичный" => "Кирпичный", "Панельный" => "Панельный", "Блочный" => "Блочный", "Монолитный" => "Монолитный", "Деревянный" => "Деревянный"));
        $this->inputs = array_add($this->inputs, "obj_build_type_2", array("Кирпич" => "Кирпич", "Брус" => "Брус", "Бревно" => "Бревно", "Металл" => "Металл", "Пеноблоки" => "Пеноблоки", "Сэндвич-панели" => "Сэндвич-панели", "Ж/б панели" => "Ж/б панели", "Экспериментальные материалы" => "Экспериментальные материалы"));
        $this->inputs = array_add($this->inputs, "obj_floor", array("1" => "1", "2" => "2", "3" => "3", "4" => "4", "5" => "5", "6" => "6", "7" => "7", "8" => "8", "9" => "9", "10" => "10", "11" => "11", "12" => "12", "13" => "13", "14" => "14", "15" => "15", "16" => "16", "17" => "16+"));
        $this->inputs = array_add($this->inputs, "obj_distance", array("0" => "В черте города", "10" => "10 км", "20" => "20 км", "30" => "30 км", "50" => "50 км", "70" => "70+ км"));
        $this->inputs = array_add($this->inputs, "obj_home_floors_1", array("1" => "1", "2" => "2", "3" => "3", "4" => "4", "5" => "5", "6" => "6", "7" => "7", "8" => "8", "9" => "9", "10" => "10", "11" => "11", "12" => "12", "13" => "13", "14" => "14", "15" => "15", "16" => "16", "17" => "16+"));
        $this->inputs = array_add($this->inputs, "obj_general_square", array("30" => "30", "32" => "32", "36" => "36", "44" => "44", "60" => "60", "66" => "66", "72" => "72", "84" => "84"));
        $this->inputs = array_add($this->inputs, "obj_square_kitchen", array("6" => "6", "7" => "7", "8" => "8", "9" => "9", "10" => "10", "12" => "12", "14" => "14", "16" => "16"));
        $this->inputs = array_add($this->inputs, "obj_square_life", array("15" => "15", "16" => "16", "18" => "18", "19" => "19", "20" => "20", "22" => "22", "30" => "30", "40" => "40"));
    }

    public function transfer(JavaScriptMaker $jsmaker, Aobject $aobject)
    {
        $this->checkUser();
        $obj_param = view(config('settings.theme').'.admin.objectParam')->with(array('category' => $aobject->category, 'deal' => "Продажа", 'type' => $aobject->type));
        $cities = $this->city_rep->get();
        $obj_city = array();
        foreach ($cities as $city) {
            $obj_city = array_add($obj_city, $city->name, $city->name );
            $obj_area = array();
            foreach ($city->areas as $area) {
                $obj_area = array_add($obj_area, $area->name, $area->name );
            }
            $this->inputs = array_add($this->inputs, "obj_area".$city->id, $obj_area);
        }
        $this->inputs = array_add($this->inputs, "obj_city", $obj_city);
        $comforts = $this->com_rep->get();
        $jsmaker->setJs("obj-edit", $aobject, true, csrf_token(), $this->randStr);
        //сделать проверочки
        $phone = preg_replace("/\D/", '', $aobject->client_contacts);
        if ($phone[0] == 8 || $phone[0] == 7) {
            $phone = substr( $phone, 1);
        }
        $aobject->client_contacts = $phone;
        $this->content = view(config('settings.theme').'.admin.objectTransfer')->with(array("object" => $aobject,'cities' => $cities, "obj_id" => $aobject->id, "comforts" => $comforts, "inputs" => $this->inputs, 'obj_param' => $obj_param, 'category' => '', 'deal' => '', 'type' => ''))->render();
        $this->title = 'Трансфер объекта';
        return $this->renderOutput();
    }

    public function store(ObjectRequest $request)
    {
        $this->checkUser();
        $request->obj_city = $this->getCityid($request->obj_city); 
        $obj_area_input = "obj_area" . $request->obj_city;
        $area = $this->getAreaid($request->input($obj_area_input));
        $result = $this->o_rep->addObject($request, $area);
        if(is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }
        $obj = Aobject::find($request->obj_id);
        $obj->delete();
        return redirect('/admin')->with($result);
    }

    public function destroy(Aobject $aobject)
    {
        $this->checkUser();
        if ($aobject->delete()) {
            return back()->with(['status' => 'Объект удален']);
        } else {
            return back()->with(['error' => 'Ошибка удаления']);
        }
    }

    public function getCityid($city) {
        $where = array("name", $city);
        $city_ = $this->city_rep->get("*", false, false, $where);
        return $city_[0]->id;
    }

    public function getAreaid($area) {
        $where = array("name", $area);
        $area_ = $this->area_rep->get("*", false, false, $where);
        return $area_[0]->id;
    }
}
