<?php

namespace App\Http\Controllers\Admin;

use App\Object;
use App\Aobject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\ObjectsRepository;
use App\Repositories\CitiesRepository;
use App\Repositories\AreasRepository;
use App\Repositories\ComfortsRepository;
use App\Components\JavaScriptMaker;
use App\Components\Array2XML;
use App\Components\ExcelExport;
use App\Http\Requests\ObjectRequest;
use Gate;
use Carbon\Carbon;
use File;
use Storage;

class ObjectController extends AdminController
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
        $this->inc_css_lib = array_add($this->inc_css_lib,'herecss', array('url' => '<link rel="stylesheet" href="https://js.api.here.com/v3/3.1/mapsjs-ui.css">'));
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
        $this->inputs = array_add($this->inputs, "obj_deal", array("Продажа" => "Продажа", "Обмен" => "Обмен"));
        $this->inputs = array_add($this->inputs, "obj_form_1", array("Вторичка" => "Вторичка", "Новостройка" => "Новостройка"));
        $this->inputs = array_add($this->inputs, "obj_form_2", array("Дом" => "Дом", "Дача" => "Дача", "Коттедж" => "Коттедж", "Таунхаус" => "Таунхаус"));
        $this->inputs = array_add($this->inputs, "client_need", array("1" => "1-к квартира","1x2" => "Две 1-к квартиры", "2" => "2-к квартира", "2x2" => "Две 2-к квартиры", "3" => "3-к квартира", "4-к квартира" => "4-к квартира", "Комната" => "Комната", "Дом" => "Дом", "Дача" => "Дача", "Коттедж" => "Коттедж", "Таунхаус" => "Таунхаус"));
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

    public function index() {
        $content = File::get(base_path("storage/objects.json"));
        $json = json_decode($content);
        foreach ($json as $obj) {
//            dump($obj);
            $this->o_rep->addObject($obj);
        }
    }


    public function getJSON() {
        $objects = $this->o_rep->get("*");
        return response()->json($objects->toArray());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(JavaScriptMaker $jsmaker, $category, $deal, $type)
    {
        $this->checkUser();
        $obj_param = view(config('settings.theme').'.admin.objectParam')->with(array('category' => $category, 'deal' => $deal, 'type' => $type));
        $cities = $this->city_rep->get();
        $obj_city = array();
        foreach ($cities as $city) {
            $obj_city = array_add($obj_city, $city->id, $city->name );
            $obj_area = array();
            foreach ($city->areas as $area) {
                $obj_area = array_add($obj_area, $area->id, $area->name );
            }
            $this->inputs = array_add($this->inputs, "obj_area".$city->id, $obj_area);
        }
        $this->inputs = array_add($this->inputs, "obj_city", $obj_city);
        $comforts = $this->com_rep->get();
        $jsmaker->setJs("obj-create", "", true, csrf_token(), $this->randStr);
        $rand_obj_id = rand(1,1000);
        $this->content = view(config('settings.theme').'.admin.objectCreate')->with(array('cities' => $cities, "obj_id" => $rand_obj_id, "comforts" => $comforts, "inputs" => $this->inputs, 'obj_param' => $obj_param, 'category' => $category, 'deal' => $deal, 'type' => $type))->render();
        $this->title = 'Создание нового объекта';
        return $this->renderOutput();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ObjectRequest $request)
    {
        $this->checkUser();
        $result = $this->o_rep->addObject($request);
        if(is_array($result) && (!empty($result['error']) || !empty($result['errors']))) {
            return back()->with($result);
        }

        return redirect('/admin')->with($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(JavaScriptMaker $jsmaker, Object $object)
    {
        $this->checkUser();
        if($this->user->cant('update', $object)) {
            return back()->with(array('error' => 'Доступ запрещен'));
        }
        $obj_param = view(config('settings.theme').'.admin.objectParam')->with(array('category' => $object->category, 'deal' => $object->deal, 'type' => $object->type));
        $cities = $this->city_rep->get();
        $obj_city = array();
        foreach ($cities as $city) {
            $obj_city = array_add($obj_city, $city->id, $city->name );
            $obj_area = array();
            foreach ($city->areas as $area) {
                $obj_area = array_add($obj_area, $area->id, $area->name );
            }
            $this->inputs = array_add($this->inputs, "obj_area".$city->id, $obj_area);
        }
        $this->inputs = array_add($this->inputs, "obj_city", $obj_city);
        $comforts = $this->com_rep->get();
        $jsmaker->setJs("obj-edit", $object, true, csrf_token(), $this->randStr);
        $object->client = json_decode($object->client);
        if ($object->client->phone[0] == "8") {
            $object->client->phone = substr( $object->client->phone, 1);
        }
        if(isset($object->phones)) $object->phones = explode(";", $object->phones);
        $this->content = view(config('settings.theme').'.admin.objectCreate')->with(array("object" => $object,'cities' => $cities, "obj_id" => $object->id, "comforts" => $comforts, "inputs" => $this->inputs, 'obj_param' => $obj_param, 'category' => '', 'deal' => $object->deal, 'type' => ''))->render();
        $this->title = 'Редактирование объекта';
        return $this->renderOutput();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Object $object)
    {
        $this->checkUser();
        if($this->user->cant('update', $object)) {
            return back()->with(array('error' => 'Доступ запрещен'));
        }
        $result = $this->o_rep->updateObject($request, $object);

        if(is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }
        if($object->out) {
            $this->ObjectsToXml();
        }
        return redirect('/admin')->with($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    //ACTIONS

    public function destroy(Object $object, Request $request)
    {
        $this->checkUser();
        if($this->user->cant('delete', $object)) {
            return back()->with(array('error' => 'Доступ запрещен'));
        }
        if ($object->forceDelete()) {
            return back()->with(['status' => 'Объект удален', 'offset' => $request->offset]);
        } else {
            return back()->with(['error' => 'Ошибка удаления', 'offset' => $request->offset]);
        }
    }

    public function InPrework(Object $object, Request $request)
    {
        $this->checkUser();
        $object->worked_at = Carbon::now();
        $object->workingUser()->associate($this->user);
        $object->preworkingUser()->dissociate();
        if ($object->update()) {
            return back()->with(['status' => 'Объект принят в работу', 'offset' => $request->offset]);
        } else {
            return back()->with(['error' => 'Ошибка принятия в работу', 'offset' => $request->offset]);
        }
    }

    public function Out(Object $object, Request $request)
    {
        $this->checkUser();
        switch ($request->target) {
            case "avito":
                $object->outed_at = Carbon::now();
                $object->out = 1;
                $object->out_avito = 1;
                if ($object->update()) {
                    $objects = Object::OutedAvito()->get();
                    $objects_all = Object::OutedAll()->get();

                    $objects_avito = array();
                    foreach($objects as $object) {
                        $objects_avito[] = $this->ObjectToArrayAvito($object);
                    }
                    foreach($objects_all as $object) {
                        $objects_avito[] = $this->ObjectToArrayAvito($object);
                    }
                    $this->putXml($objects_avito, "avito");

                    //@TODO: ДОДЕЛАТЬ ОФФСЕТ
                    return back()->with(['status' => 'Объект добавлен на выгрузку', 'offset' => $request->offset]);
                } else {
                    return back()->with(['error' => 'Ошибка добавления на выгрузку', 'offset' => $request->offset]);
                }
                break;
            case "click":
                $object->outed_at = Carbon::now();
                $object->out = 1;
                $object->out_click = 1;
                if ($object->update()) {
                    $objects = Object::OutedClick()->get();
                    $objects_all = Object::OutedAll()->get();

                    $objects_click = array();
                    foreach($objects as $object) {
                        $objects_click[] = $this->ObjectToArrayClick($object);
                    }
                    foreach($objects_all as $object) {
                        $objects_click[] = $this->ObjectToArrayClick($object);
                    }
                    $this->putXml($objects_click, "click");

                    //@TODO: ДОДЕЛАТЬ ОФФСЕТ
                    return back()->with(['status' => 'Объект добавлен на выгрузку', 'offset' => $request->offset]);
                } else {
                    return back()->with(['error' => 'Ошибка добавления на выгрузку', 'offset' => $request->offset]);
                }
                break;
            case "yandex":
                $object->outed_at = Carbon::now();
                $object->out = 1;
                $object->out_yandex = 1;
                if ($object->update()) {
                    $objects = Object::OutedYandex()->get();
                    $objects_all = Object::OutedAll()->get();
                    $objects_yandex = array();
                    foreach($objects as $object) {
                        $objects_yandex[] = $this->ObjectToArrayYandex($object);
                    }
                    foreach($objects_all as $object) {
                        $objects_yandex[] = $this->ObjectToArrayYandex($object);
                    }
                    $this->putXml($objects_yandex, "yandex");
                    //@TODO: ДОДЕЛАТЬ ОФФСЕТ
                    return back()->with(['status' => 'Объект добавлен на выгрузку', 'offset' => $request->offset]);
                } else {
                    return back()->with(['error' => 'Ошибка добавления на выгрузку', 'offset' => $request->offset]);
                }
                break;
            default:
                $object->outed_at = Carbon::now();
                $object->out = 1;
                $object->out_yandex = 0;
                $object->out_avito = 0;
                $object->out_click = 0;
                $object->out_all = 1;
                if ($object->update()) {
                    $this->ObjectsToXml();
                    //@TODO: ДОДЕЛАТЬ ОФФСЕТ
                    return back()->with(['status' => 'Объект добавлен на выгрузку', 'offset' => $request->offset]);
                } else {
                    return back()->with(['error' => 'Ошибка добавления на выгрузку', 'offset' => $request->offset]);
                }
                break;
        }
    }

    public function UnOut(Object $object, Request $request)
    {
        $this->checkUser();
        $object->outed_at = null;
        $object->out = 0;
        $object->out_avito = 0;
        $object->out_yandex = 0;
        $object->out_click = 0;
        $object->out_all = 0;
        if ($object->update()) {
            $this->ObjectsToXml();
            return back()->with(['status' => 'Объект удален из выгрузки', 'offset' => $request->offset]);
        } else {
            return back()->with(['error' => 'Ошибка удаления из выгрузки', 'offset' => $request->offset]);
        }
    }

    public function AccessPrework(Object $object, Request $request)
    {
        $this->checkUser();
        $user = $object->preworkingUser;
        $object->worked_at = Carbon::now();
        $object->workingUser()->associate($user);
        $object->preworkingUser()->dissociate();
        if ($object->update()) {
            return back()->with(['status' => 'Объект принят в работу', 'offset' => $request->offset]);
        } else {
            return back()->with(['error' => 'Ошибка принятия в работу', 'offset' => $request->offset]);
        }
    }

    public function CancelPrework(Object $object, Request $request)
    {
        $this->checkUser();
        $object->preworkingUser()->dissociate();
        if ($object->update()) {
            return back()->with(['status' => 'Объект отклонен', 'offset' => $request->offset]);
        } else {
            return back()->with(['error' => 'Ошибка отклонения', 'offset' => $request->offset]);
        }
    }

    public function Unwork(Object $object, Request $request)
    {
        $this->checkUser();
        $object->workingUser()->dissociate();
        if ($object->update()) {
            return back()->with(['status' => 'Объект убран из работы', 'offset' => $request->offset]);
        } else {
            return back()->with(['error' => 'Ошибка удаления из работы', 'offset' => $request->offset]);
        }
    }

    public function CheckCompleted(Object $object, Request $request){
//        if (request()->ip() != "193.124.189.57"){
//            abort(404);
//        }
        $objects = $object->InNotWorkAll()->get();
        foreach ($objects as $object) {
            if (!isset($object->activate_state)) {
                $object->activate_state = 0;
            }
            if($object->created_at->addMonths(1 + $object->activate_state) < Carbon::now()) {
                $object->activate_state++;
                $user = $object->created_id;
                $object->completedUser()->associate($user);
                $object->update();
            }
        }
    }

    public function Activate(Object $object, Request $request)
    {
        $this->checkUser();
        $object->activate_at = Carbon::now();
        $object->completedUser()->dissociate();
        $state = $object->activate_state;
        if ($state != null) {
            $object->activate_state = ++$state;
        } else {
            $object->activate_state = 1;
        }
        if ($object->update()) {
            return back()->with(['status' => 'Объект активирован', 'offset' => $request->offset]);
        } else {
            return back()->with(['error' => 'Ошибка активацции', 'offset' => $request->offset]);
        }
    }

    public function Restore(Object $object, Request $request)
    {
        $this->checkUser();
        $object->deletedUser()->dissociate();
        $object->update();
        if ($object->restore()) {
            return back()->with(['status' => 'Объект восстановлен', 'offset' => $request->offset]);
        } else {
            return back()->with(['error' => 'Ошибка восстановления', 'offset' => $request->offset]);
        }
    }

    public function softDelete(Object $object, Request $request)
    {
        $this->checkUser();
        if($this->user->cant('softdelete', $object)) {
            return back()->with(array('error' => 'Доступ запрещен'));
        }
        $object->deletedUser()->associate($this->user);
        $object->update();
        if ($object->delete()) {
            return back()->with(['status' => 'Объект удален', 'offset' => $request->offset]);
        } else {
            return back()->with(['error' => 'Ошибка удаления', 'offset' => $request->offset]);
        }
    }

    public function export(ExcelExport $excel, Request $request) {
        $this->checkUser();
        if($request->user != "") {
            $objects = $this->o_rep->get("*", false, false, array("created_id", $request->user));
        } else {
            $objects = $this->o_rep->get();
        }
        $excel->Export($objects, $this->user->login);
        $path = storage_path().'/app/public/'.env('THEME','default').'/xlsx/'.$this->user->login.'.xlsx';
        if (file_exists($path)) {
            return response()->download($path);
        }
    }

    public function AobjDelete(Aobject $aobject, Request $request)
    {
        $this->checkUser();
        if ($aobject->delete()) {
            return back()->with(['status' => 'Объект удален', 'offset' => $request->offset]);
        } else {
            return back()->with(['error' => 'Ошибка удаления', 'offset' => $request->offset]);
        }
    }

    public function ShowPhone(Object $object) {
        $this->checkUser();
        $object->client = json_decode($object->client);
        if($this->user->can('viewContacts', $this->user)) {
            if((isset($object->working_id) && $object->workingUser->id == $this->user->id) || !isset($object->working_id) || $this->user->isAdmin()) {
                $phone = $object->client->phone;
                $name = $object->client->name;
                $father_name = $object->client->father_name;
            } else {
                $phone = $object->workingUser->telefon;
                $name = $object->workingUser->name;
                $father_name = '';
            }
        } else {
            $phone = $object->createdUser->telefon;
            $name = $object->createdUser->name;
            $father_name = '';
        }
        //сделать проверочки
        $phone = preg_replace("/[^,.0-9]/", '', $phone);
        if ($phone[0] == 8 || $phone[0] == 7) {
            $phone = substr( $phone, 1);
        }
        $phone = "8" . $phone;
        $number = $phone;
        if(isset($object->phones)) {
            $phone = "<span>".$object->client->phone. "</span>";
            $phones = explode(';', $object->phones);
            foreach ($phones as $phone_) {
                $phone .= "</br><span>";
                $phone .= "+7" . $phone_ . "</span>";
            }
        }
        return response()->json([
            'id'   => $object->id,
            'name' => $name,
            'phone' => $phone,
            'number' => $number,
            'father_name' => $father_name
        ]);
    }

    public function MassAction(Request $request){
        $this->checkUser();
        $objects = Object::select("*")->whereIn("id", $request->objects)->withTrashed()->get();
        switch ($request->mass_actions) {
            case "delete":
                foreach ($objects as $object) {
                    if ($object->workingUser == null || $this->user->role->name == "admin" || $object->workingUser->id == $this->user->id) {
                        if($this->user->cant('softdelete', $object)) {
                            return back()->with(array('error' => 'Доступ запрещен'));
                        }
                        $object->deletedUser()->associate($this->user);
                        $object->update();
                        $object->delete();
                    }
                }
                return back()->with(['status' => 'Объекты удалены']);
                break;
            case "inprework":
                foreach ($objects as $object) {
                    if ($object->preworkingUser == null && $object->workingUser == null) {
                        $object->preworkingUser()->associate($this->user);
                        $object->update();
                    }
                }
                return back()->with(['status' => 'Объекты поданы в работу']);
                break;
            case "inwork":
                foreach ($objects as $object) {
                    if ($object->preworkingUser == null && $object->workingUser == null) {
                        $object->workingUser()->associate($this->user);
                        $object->update();
                    }
                }
                return back()->with(['status' => 'Объекты взяты в работу']);
                break;
            case "accept_prework":
                if($this->user->role->name != "admin") {
                    return back()->with(['error' => 'Доступ запрещен']);
                }
                foreach ($objects as $object) {
                    $user = $object->preworkingUser;
                    $object->worked_at = Carbon::now();
                    $object->workingUser()->associate($user);
                    $object->preworkingUser()->dissociate();
                    $object->update();
                }
                return back()->with(['status' => 'Объекты подтверждены']);
                break;
            case "cancel_prework":
                if($this->user->role->name != "admin") {
                    return back()->with(['error' => 'Доступ запрещен']);
                }
                foreach ($objects as $object) {
                    $object->preworkingUser()->dissociate();
                    $object->update();
                }
                return back()->with(['status' => 'Объекты отклонены']);
                break;
            case "activate":
                foreach ($objects as $object) {
                        if($object->completedUser->id == $this->user->id || $this->user->role->name == "admin") {
                            $object->activate_at = Carbon::now();
                            $object->completedUser()->dissociate();
                            $state = $object->activate_state;
                            if ($state != null) {
                                $object->activate_state = ++$state;
                            } else {
                                $object->activate_state = 1;
                            }
                            $object->update();
                        }
                    }
                    return back()->with(['status' => 'Объекты активированы']);
                break;
            case "out":
                foreach ($objects as $object) {
                    if($object->workingUser->id == $this->user->id || $this->user->role->name == "admin") {
                        $object->outed_at = Carbon::now();
                        $object->out = 1;
                        $object->out_yandex = 0;
                        $object->out_avito = 0;
                        $object->out_click = 0;
                        $object->out_all = 1;
                        $object->update();
                    }
                }
                $this->ObjectsToXml();
                return back()->with(['status' => 'Объекты добавлены на выгрузку']);
                break;
            case "unwork":
                foreach ($objects as $object) {
                    if(($object->workingUser->id == $this->user->id) || $this->user->role->name == "admin") {
                        $object->workingUser()->dissociate();
                        $object->update();
                    }
                }
                return back()->with(['status' => 'Объекты убраны из работы']);
                break;
            case "unout":
                foreach ($objects as $object) {
                    if($this->user->role->name == "admin") {
                        $object->outed_at = null;
                        $object->out = 0;
                        $object->out_avito = 0;
                        $object->out_yandex = 0;
                        $object->out_click = 0;
                        $object->out_all = 0;
                        $object->update();
                    }
                }
                $objects_ = Object::Outed()->get();
                $this->ObjectsToXml($objects_);
                    return back()->with(['status' => 'Объекты удалены из выгрузки']);
                break;
            case "destroy":
                if($this->user->role->name != "admin") {
                    return back()->with(['error' => 'Доступ запрещен']);
                }
                foreach ($objects as $object) {
                    if($this->user->cant('delete', $object)) {
                        return back()->with(array('error' => 'Доступ запрещен'));
                    }
                    $object->forceDelete();
                }
                    return back()->with(['status' => 'Объекты удалены']);
                break;
            case "recover":
                if($this->user->role->name != "admin") {
                    return back()->with(['error' => 'Доступ запрещен']);
                }
                foreach ($objects as $object) {
                    $object->deletedUser()->dissociate();
                    $object->update();
                    $object->restore();
                }
                return back()->with(['status' => 'Объекты восстановлены']);
                break;
            default:
                return back();
                break;
        }
    }

    public function allCompleted(){
        $this->checkUser();
    }

    public function createDistricts(){
       $objects = Object::select("*")->withTrashed()->get();
       foreach ($objects as $object) {
           if (preg_match("/Квартал/i", $object->raion->name)) {
               $object->district = "Старый город";
               if ($object->update()) {
                   dump("Вхождение найдено." . $object->raion->name);
               }
           } else {
               $object->district = "Новый город";
               if ($object->update()) {
                   dump("Вхождение не найдено." . $object->raion->name);
               }
           }
       }
    }

    public function ObjectsToXml() {
        $objects_avito = array();
        $objects_yandex = array();
        $objects_click = array();
        $objects_to_avito = Object::OutedAvito()->get();
        $objects_to_yandex = Object::OutedYandex()->get();
        $objects_to_click = Object::OutedClick()->get();
        $objects_to_all = Object::OutedAll()->get();

        foreach($objects_to_avito as $object) {
            $objects_avito[] = $this->ObjectToArrayAvito($object);
        }

        foreach($objects_to_yandex as $object) {
            $objects_yandex[] = $this->ObjectToArrayYandex($object);
        }

        foreach($objects_to_click as $object) {
            $objects_click[] = $this->ObjectToArrayClick($object);
        }

        foreach($objects_to_all as $object) {
            $objects_avito[] = $this->ObjectToArrayAvito($object);
            $objects_yandex[] = $this->ObjectToArrayYandex($object);
            $objects_click[] = $this->ObjectToArrayClick($object);
        }

        $this->putXml($objects_avito, "avito");
        $this->putXml($objects_yandex, "yandex");
        $this->putXml($objects_click, "click");
    }

    private function putXml($objects, $target) {
        switch ($target) {
            case "yandex":
                $php_array = array("generation-date" => Carbon::now()->toIso8601String(), "offer" => $objects);
                $php_array["@attributes"] = array("xmlns" => "http://webmaster.yandex.ru/schemas/feed/realty/2010-06");
//                $php_array["@attributes"] = array("target" => "Avito.ru", "formatVersion" => 3);
                $xml_avito = Array2XML::createXML('realty-feed', $php_array);
                Storage::disk('xml')->put($target . '.xml', $xml_avito->saveXML());
                break;
            default:
                $php_array = array("Ad" => $objects);
                $php_array["@attributes"] = array("target" => "Avito.ru", "formatVersion" => 3);
                $xml_avito = Array2XML::createXML('Ads', $php_array);
                Storage::disk('xml')->put($target . '.xml', $xml_avito->saveXML());
                break;

        }
    }

    private function ObjectToArrayAvito(Object $object) {
        $geo = explode(",", $object->geo);
        $companyName = "АН \"Новая Жизнь\"";
        $region = "Волгоградская область";
        $rights = "Посредник";
        $obj = array();
        switch ($object->category) {
            case "1":
                $obj["Id"] = md5($object->id);
                $obj["Category"] = "Квартиры";
                $obj["Status"] = "Квартира";
                $obj["OperationType"] = "Продам";
                //поменять
                $obj["DateBegin"] = $object->outed_at->format('Y-m-d');
                $obj["Description"] = nl2br($object->desc);
                $obj["AdStatus"] = "Free";
                $obj["EMail"] = $object->createdUser->email ?? "rieltor2009@ya.ru";
                $obj["CompanyName"] = $companyName;
                if($object->working_id) {
                    $obj["ManagerName"] = $object->workingUser->name;
                    $obj["ContactPhone"] = $object->workingUser->telefon;
                } else {
                    $obj["ManagerName"] = $object->createdUser->name;
                    $obj["ContactPhone"] = $object->createdUser->telefon;
                }
                $obj["Region"] = $region;
                $obj["City"] = $object->gorod->name;
                $obj["District"] = $object->district;
                $obj["Street"] = $object->address;
                $obj["Latitude"] = trim($geo[0]);
                $obj["Longitude"] = trim($geo[1]);
                $obj["Price"] = $object->price;
                $obj["Floor"] = $object->floor;
                $obj["Floors"] = $object->build_floors;
                $obj["Rooms"] = $object->rooms;
                $obj["HouseType"] = $object->build_type;
                $obj["Square"] = $object->square;
                $obj["LivingSpace"] = $object->square_life;
                $obj["KitchenSpace"] = $object->square_kitchen;
                $obj["MarketType"] = $object->type;
                $obj["PropertyRights"] = $rights;
                $obj["CadastralNumber"] = $object->cadastral;
                if ($object->images->isNotEmpty()) {
                    $images = array();
                    foreach ($object->images as $image) {
                        $images[] = array("@attributes" => array("url" => asset(config('settings.theme'))."/uploads/images/".$image->object_id."/".$image->new_name));
                    }
                    $obj["Images"] = array("Image" => $images);
                }
                break;
            case "2":
                $obj["Id"] = md5($object->id);
                $obj["Category"] = "Дома, дачи, коттеджи";
                $obj["OperationType"] = "Продам";
                $obj["Status"] = "Квартира";
                //поменять
                $obj["DateBegin"] = $object->outed_at->format('Y-m-d');
                $obj["Description"] = nl2br($object->desc);
                $obj["AdStatus"] = "Free";
                $obj["EMail"] = $object->createdUser->email ?? "rieltor2009@ya.ru";
                $obj["CompanyName"] = $companyName;
                if($object->working_id) {
                    $obj["ManagerName"] = $object->workingUser->name;
                    $obj["ContactPhone"] = $object->workingUser->telefon;
                } else {
                    $obj["ManagerName"] = $object->createdUser->name;
                    $obj["ContactPhone"] = $object->createdUser->telefon;
                }
                $obj["Region"] = $region;
                $obj["City"] = $object->gorod->name;
                $obj["District"] = $object->district;
                $obj["Street"] = $object->address;
                $obj["Latitude"] = trim($geo[0]);
                $obj["Longitude"] = trim($geo[1]);
                $obj["Price"] = $object->price;
                $obj["ObjectType"] = $object->type;
                $obj["Floors"] = $object->build_floors;
                $obj["WallsType"] = $object->build_type;
                $obj["Square"] = $object->home_square;
                //так?
                $obj["LandArea"] = $object->earth_square;
                $obj["PropertyRights"] = $rights;
                $obj["DistanceToCity"] = $object->distance;
                $obj["CadastralNumber"] = $object->cadastral;
                if ($object->images->isNotEmpty()) {
                    $images = array();
                    foreach ($object->images as $image) {
                        $images[] = array("@attributes" => array("url" => asset(config('settings.theme'))."/uploads/images/".$image->object_id."/".$image->new_name));
                    }
                    $obj["Images"] = array("Image" => $images);
                }
                break;
            case "3":
                $obj["Id"] = md5($object->id);
                $obj["Category"] = "Комнаты";
                $obj["OperationType"] = "Продам";
                $obj["Status"] = "Квартира";
                //поменять
                $obj["DateBegin"] = $object->outed_at->format('Y-m-d');
                $obj["Description"] = nl2br($object->desc);
                $obj["AdStatus"] = "Free";
                $obj["EMail"] = $object->createdUser->email ?? "rieltor2009@ya.ru";
                $obj["CompanyName"] = $companyName;
                if($object->working_id) {
                    $obj["ManagerName"] = $object->workingUser->name;
                    $obj["ContactPhone"] = $object->workingUser->telefon;
                } else {
                    $obj["ManagerName"] = $object->createdUser->name;
                    $obj["ContactPhone"] = $object->createdUser->telefon;
                }
                $obj["Region"] = $region;
                $obj["City"] = $object->gorod->name;
                $obj["District"] = $object->district;
                $obj["Street"] = $object->address;
                $obj["Latitude"] = trim($geo[0]);
                $obj["Longitude"] = trim($geo[1]);
                $obj["Price"] = $object->price;
                $obj["Floor"] = $object->floor;
                $obj["Floors"] = $object->build_floors;
                $obj["Rooms"] = $object->rooms;
                $obj["HouseType"] = $object->build_type;
                $obj["Square"] = $object->square;
                $obj["PropertyRights"] = $rights;
                $obj["CadastralNumber"] = $object->cadastral;
                if ($object->images->isNotEmpty()) {
                    $images = array();
                    foreach ($object->images as $image) {
                        $images[] = array("@attributes" => array("url" => asset(config('settings.theme'))."/uploads/images/".$image->object_id."/".$image->new_name));
                    }
                    $obj["Images"] = array("Image" => $images);
                }
                break;
            default:
                break;
        }
        return $obj;
    }

    private function ObjectToArrayYandex(Object $object) {
        $geo = explode(",", $object->geo);
        $companyName = "АН \"Новая Жизнь\"";
        $region = "Волгоградская область";
        $rights = "Посредник";
        $obj = array();
        switch ($object->category) {
            case "1":
                $obj["@attributes"] = array("internal-id" => md5($object->id));
                $obj["category"] = "квартира";
                $obj["type"] = "продажа";
                $obj["property-type"] = "жилая";
                $obj["cadastral-number"] = $object->cadastral;
                $obj["creation-date"] = $object->created_at->toIso8601String();
                $obj["last-update-date"] = $object->updated_at->toIso8601String();
                $obj["location"] = [
                    "country" => "Россия",
                    "region" => "Волгоградская область",
                    "locality-name" => $object->gorod->name,
                    "address" => $object->address
                    ];
//                $obj["latitude"] = trim($geo[0]);
//                $obj["longitude"] = trim($geo[1]);
                $obj["sales-agent"] = [
                    "category" => "agency",
                    "phone" => $object->working_id ? $object->workingUser->telefon : $object->createdUser->telefon,
                    "name" => $object->working_id ? $object->workingUser->name : $object->createdUser->name,
                    "organization" => $companyName,
                    "url" => "http://обменжилья.рф"
                ];
                $obj["price"] = [
                    "value" => $object->price,
                    "currency" => "RUR"
                ];
                $obj["deal-status"] = "первичная продажа вторички";
                $obj["area"] = [
                  "value" => $object->square,
                  "unit" => "кв. м",
                ];
                if ($object->images->isNotEmpty()) {
                    $images = array();
                    foreach ($object->images as $image) {
                        $images[] = asset(config('settings.theme'))."/uploads/images/".$image->object_id."/".$image->new_name;
                    }
                    $obj["image"] = $images;
                }
                $obj["description"] = $object->desc;
                $obj["rooms"] = $object->rooms;
                $obj["rooms-offered"] = $object->rooms;
                $obj["floor"] = $object->floor;
                $obj["floors-total"] = $object->build_floors;
                $obj["building-type"] = strtolower($object->build_type);
                break;
            case "2":
                $obj["@attributes"] = array("internal-id" => md5($object->id));
                $obj["category"] = strtolower($object->type);
                $obj["type"] = "продажа";
                $obj["property-type"] = "жилая";
                $obj["cadastral-number"] = $object->cadastral;
                $obj["creation-date"] = $object->created_at->toIso8601String();
                $obj["last-update-date"] = $object->updated_at->toIso8601String();
                $obj["location"] = [
                    "country" => "Россия",
                    "region" => "Волгоградская область",
                    "locality-name" => $object->gorod->name,
                    "address" => $object->address
                ];
//                $obj["latitude"] = trim($geo[0]);
//                $obj["longitude"] = trim($geo[1]);
                $obj["sales-agent"] = [
                    "category" => "agency",
                    "phone" => $object->working_id ? $object->workingUser->telefon : $object->createdUser->telefon,
                    "name" => $object->working_id ? $object->workingUser->name : $object->createdUser->name,
                    "organization" => $companyName,
                    "url" => "http://обменжилья.рф"
                ];
                $obj["price"] = [
                    "value" => $object->price,
                    "currency" => "RUR"
                ];
                $obj["deal-status"] = "первичная продажа вторички";
                $obj["area"] = [
                    "value" => $object->home_square,
                    "unit" => "кв. м",
                ];
                if ($object->images->isNotEmpty()) {
                    $images = array();
                    foreach ($object->images as $image) {
                        $images[] = asset(config('settings.theme'))."/uploads/images/".$image->object_id."/".$image->new_name;
                    }
                    $obj["image"] = $images;
                }
                $obj["description"] = $object->desc;
                $obj["floors-total"] = $object->build_floors;
                $obj["building-type"] = strtolower($object->build_type);
                break;
            case "3":
                $obj["@attributes"] = array("internal-id" => md5($object->id));
                $obj["category"] = "комната";
                $obj["type"] = "продажа";
                $obj["property-type"] = "жилая";
                $obj["cadastral-number"] = $object->cadastral;
                $obj["creation-date"] = $object->created_at->toIso8601String();
                $obj["last-update-date"] = $object->updated_at->toIso8601String();
                $obj["location"] = [
                    "country" => "Россия",
                    "region" => "Волгоградская область",
                    "locality-name" => $object->gorod->name,
                    "address" => $object->address
                ];
//                $obj["latitude"] = trim($geo[0]);
//                $obj["longitude"] = trim($geo[1]);
                $obj["sales-agent"] = [
                    "category" => "agency",
                    "phone" => $object->working_id ? $object->workingUser->telefon : $object->createdUser->telefon,
                    "name" => $object->working_id ? $object->workingUser->name : $object->createdUser->name,
                    "organization" => $companyName,
                    "url" => "http://обменжилья.рф"
                ];
                $obj["price"] = [
                    "value" => $object->price,
                    "currency" => "RUR"
                ];
                $obj["deal-status"] = "первичная продажа вторички";
                $obj["area"] = [
                    "value" => $object->square,
                    "unit" => "кв. м",
                ];
                if ($object->images->isNotEmpty()) {
                    $images = array();
                    foreach ($object->images as $image) {
                        $images[] = asset(config('settings.theme'))."/uploads/images/".$image->object_id."/".$image->new_name;
                    }
                    $obj["image"] = $images;
                }
                $obj["description"] = $object->desc;
                $obj["rooms"] = $object->rooms;
                $obj["rooms-offered"] = $object->rooms;
                $obj["floor"] = $object->floor;
                $obj["floors-total"] = $object->build_floors;
                $obj["building-type"] = strtolower($object->build_type);
                break;
            default:
                break;
        }
        return $obj;
    }

    private function ObjectToArrayClick(Object $object) {
        $geo = explode(",", $object->geo);
        $companyName = "АН \"Новая Жизнь\"";
        $region = "Волгоградская область";
        $rights = "Посредник";
        $obj = array();
        switch ($object->category) {
            case "1":
                $obj["Id"] = md5($object->id);
                $obj["Category"] = "Квартиры";
                $obj["OperationType"] = "Продам";
                //поменять
                $obj["DateBegin"] = $object->outed_at->format('Y-m-d');
                $obj["Description"] = nl2br($object->desc);
                $obj["AdStatus"] = "Free";
                $obj["EMail"] = $object->createdUser->email;
                $obj["CompanyName"] = $companyName;
                if($object->working_id) {
                    $obj["ManagerName"] = $object->workingUser->name;
                    $obj["ContactPhone"] = $object->workingUser->telefon;
                } else {
                    $obj["ManagerName"] = $object->createdUser->name;
                    $obj["ContactPhone"] = $object->createdUser->telefon;
                }
                $obj["Region"] = $region;
                $obj["City"] = $object->gorod->name;
                $obj["District"] = $object->district;
                $obj["Street"] = $object->address;
                $obj["Latitude"] = trim($geo[0]);
                $obj["Longitude"] = trim($geo[1]);
                $obj["Price"] = $object->price;
                $obj["Floor"] = $object->floor;
                $obj["Floors"] = $object->build_floors;
                $obj["Rooms"] = $object->rooms;
                $obj["HouseType"] = $object->build_type;
                $obj["Square"] = $object->square;
                $obj["LivingSpace"] = $object->square_life;
                $obj["KitchenSpace"] = $object->square_kitchen;
                $obj["MarketType"] = $object->type;
                $obj["PropertyRights"] = $rights;
                $obj["CadastralNumber"] = $object->cadastral;
                if ($object->images->isNotEmpty()) {
                    $images = array();
                    foreach ($object->images as $image) {
                        $images[] = array("@attributes" => array("url" => asset(config('settings.theme'))."/uploads/images/".$image->object_id."/".$image->new_name));
                    }
                    $obj["Images"] = array("Image" => $images);
                }
                break;
            case "2":
                $obj["Id"] = md5($object->id);
                $obj["Category"] = "Дома, дачи, коттеджи";
                $obj["OperationType"] = "Продам";
                //поменять
                $obj["DateBegin"] = $object->outed_at->format('Y-m-d');
                $obj["Description"] = nl2br($object->desc);
                $obj["AdStatus"] = "Free";
                $obj["EMail"] = $object->createdUser->email;
                $obj["CompanyName"] = $companyName;
                if($object->working_id) {
                    $obj["ManagerName"] = $object->workingUser->name;
                    $obj["ContactPhone"] = $object->workingUser->telefon;
                } else {
                    $obj["ManagerName"] = $object->createdUser->name;
                    $obj["ContactPhone"] = $object->createdUser->telefon;
                }
                $obj["Region"] = $region;
                $obj["City"] = $object->gorod->name;
                $obj["District"] = $object->district;
                $obj["Street"] = $object->address;
                $obj["Latitude"] = trim($geo[0]);
                $obj["Longitude"] = trim($geo[1]);
                $obj["Price"] = $object->price;
                $obj["ObjectType"] = $object->type;
                $obj["Floors"] = $object->build_floors;
                $obj["WallsType"] = $object->build_type;
                $obj["Square"] = $object->home_square;
                //так?
                $obj["LandArea"] = $object->earth_square;
                $obj["PropertyRights"] = $rights;
                $obj["DistanceToCity"] = $object->distance;
                $obj["CadastralNumber"] = $object->cadastral;
                if ($object->images->isNotEmpty()) {
                    $images = array();
                    foreach ($object->images as $image) {
                        $images[] = array("@attributes" => array("url" => asset(config('settings.theme'))."/uploads/images/".$image->object_id."/".$image->new_name));
                    }
                    $obj["Images"] = array("Image" => $images);
                }
                break;
            case "3":
                $obj["Id"] = md5($object->id);
                $obj["Category"] = "Комнаты";
                $obj["OperationType"] = "Продам";
                //поменять
                $obj["DateBegin"] = $object->outed_at->format('Y-m-d');
                $obj["Description"] = nl2br($object->desc);
                $obj["AdStatus"] = "Free";
                $obj["EMail"] = $object->createdUser->email;
                $obj["CompanyName"] = $companyName;
                if($object->working_id) {
                    $obj["ManagerName"] = $object->workingUser->name;
                    $obj["ContactPhone"] = $object->workingUser->telefon;
                } else {
                    $obj["ManagerName"] = $object->createdUser->name;
                    $obj["ContactPhone"] = $object->createdUser->telefon;
                }
                $obj["Region"] = $region;
                $obj["City"] = $object->gorod->name;
                $obj["District"] = $object->district;
                $obj["Street"] = $object->address;
                $obj["Latitude"] = trim($geo[0]);
                $obj["Longitude"] = trim($geo[1]);
                $obj["Price"] = $object->price;
                $obj["Floor"] = $object->floor;
                $obj["Floors"] = $object->build_floors;
                $obj["Rooms"] = $object->rooms;
                $obj["HouseType"] = $object->build_type;
                $obj["Square"] = $object->square;
                $obj["PropertyRights"] = $rights;
                $obj["CadastralNumber"] = $object->cadastral;
                if ($object->images->isNotEmpty()) {
                    $images = array();
                    foreach ($object->images as $image) {
                        $images[] = array("@attributes" => array("url" => asset(config('settings.theme'))."/uploads/images/".$image->object_id."/".$image->new_name));
                    }
                    $obj["Images"] = array("Image" => $images);
                }
                break;
            default:
                break;
        }
        return $obj;
    }


}
