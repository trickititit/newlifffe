<?php
/**
 * Created by PhpStorm.
 * User: Pavel
 * Date: 17.12.2018
 * Time: 22:16
 */

namespace App\Parsers\Avito;

use GuzzleHttp\Client;
use App\Repositories\AobjectsRepository;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Log;
use App\Aobject;


/**
 * Class AvitoMobileParser
 * @package App\Parsers\Avito
 */
class AvitoMobileParser
{
    /**
     * @var string
     * Без последнего слеша
     */
    public $BaseUrl = 'https://m.avito.ru';
    /**
     * @var string
     */
    public $UserAgent = 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.105 Mobile Safari/537.36';
    public $Delay = 5;
    /**
     * @var int
     * 30 - дефолт мобильной версии.
     * 100 вроде нормально.
     */
    public $Limit = 30;
    /**
     * @var int
     * 24 - квартиры
     * 23 - комнаты
     * 25 - дома, дачи, коттеджи
     */
    public $CategoryId = 24;
    /**
     * @var bool
     * Искать только частные объявления.
     *
     */
    public $IsPrivateOnly = true;

    public $mainCount = 0;

    /**
     * @var int
     * 624850 - Волжский
     * 625270 - Средняя Ахтуба
     */

    public $LocationId = 624850;
    /**
     * @var mixed|string
     * Типо секретный апи ключ
     */
    private $key = '';
    /**
     * @var
     */
    private $client;

    private $a_obj;

    /**
     * @var string
     * Прокся для запросов.
     * Раскоменти в $default_config. Нужны только русские прокси, иначе апи avito.ru не отвечает.
     * возможно avito.com?
     */
    public $proxy = 'tcp://12.34.56.78:3128';



    public function __construct(AobjectsRepository $a_obj)
    {
        $default_config = [
            'verify' => TRUE,
            'timeout' => 30,
            'headers' => [
                'User-Agent' => $this->UserAgent,
            ],
            'cookie' => true,
            'cookies' => true,
            'http-error' => false,
            //  'proxy' => $proxy
        ];
        $this->client = new Client($default_config);
        $this->a_obj = $a_obj;
        $this->init();

    }

    private function getCity($location_id)
    {
        switch ($location_id) {
            case "624850":
                return "Волжский";
            case "625270":
                return "Средняя Ахтуба";
            default:
                return false;
        }
    }

    private function init()
    {
        $res = $this->client->request('GET', $this->BaseUrl, [
        ]);

        if ($res->getStatusCode() != '200')
            throw new \Exception('Не удается подключиться к сайту');
  //      $subject = $res->getBody();

//        $tag = 'script';
//        $matchGroup = $this->getTags($tag, $subject);
        $this->key = "af0deccbgcgidddjgnvljitntccdduijhdinfgjgfjir";
   //     foreach ($matchGroup as $item) {
//            if (strpos($item, 'mstatic/build') !== false) {
//                if (preg_match('~"([^"]*)"~u', $item, $m)) {
//
////                    $res = $this->client->request('GET', "https:" . $m[1], []);
////                    $mainJsText = $res->getBody()->getContents();
////                    $this->key = $this->getKey($mainJsText);
//                    if ($this->key == null) {
//                        throw new \Exception('Ключ Api не получен');
//                    }
//                    break;
//                } else throw new \Exception('Не найден главный js скрипт сайта. Возможно изменена структура');
//            }
//        }

    }

    /**
     * @param $page - начальная страница
     * @param $lastStamp - момент последнего обновления
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function ParseAllPages($page, $lastStamp)
    {
        if ($this->key == null) throw new \Exception('Нет ключа');

        $more = true;
        $parsedCount = 0;
        $parsingCount = 0;
        while ($more) {
            if ($this->IsPrivateOnly) {
                switch ($this->CategoryId) {


                    case "23":
                        $link = '/api/9/items?key=' . $this->key . '&owner[]=private&locationId=' . $this->LocationId . '&categoryId=' . $this->CategoryId . '&params[200]=1054&page=' . $page . '&lastStamp=' . $lastStamp . '&display=list&limit=' . $this->Limit;
                        break;
                    case "24":
                        $link = '/api/9/items?key=' . $this->key . '&owner[]=private&locationId=' . $this->LocationId . '&categoryId=' . $this->CategoryId . '&params[201]=1059&page=' . $page . '&lastStamp=' . $lastStamp . '&display=list&limit=' . $this->Limit;
                    break;
                    case "25":
                        $link = '/api/9/items?key=' . $this->key . '&owner[]=private&locationId=' . $this->LocationId . '&categoryId=' . $this->CategoryId . '&params[202]=1064&page=' . $page . '&lastStamp=' . $lastStamp . '&display=list&limit=' . $this->Limit;
                    break;
                    default:
                        throw new \Exception('Неверный тип запроса LocationId');
                        break;
                }

            } else
                $link = '/api/9/items?key=' . $this->key . '&locationId=' . $this->LocationId . '&categoryId=' . $this->CategoryId . '&page=' . $page . '&lastStamp=' . $lastStamp . '&display=list&limit=' . $this->Limit;
            // $cookieJar = $this->client->getConfig('cookies');
            //  $cookieJar->toArray();
            //  dd($cookieJar);
            //dd($link);
            $res = $this->client->request('GET', $this->BaseUrl . $link, []);
            if ($res->getStatusCode() != 200) log('Неудачный запрос ' . $link);
            $content = $res->getBody()->getContents();
            $contents = json_decode($content);
            if ($contents->status != 'ok') {
                throw new \Exception('Авито отклонило запрос  ' . $link);
            }
            $this->mainCount = $contents->result->mainCount;
            //dd($contents);

//            $link = '/api/2/items/search/header?key=' . $this->key . '&parameters%5BcategoryId%5D=' . $this->CategoryId . '&parameters%5BlocationId%5D=' . $this->LocationId . '&parameters%5Bowner%5D%5B0%5D=private';
//            $res = $this->client->request('GET', $this->BaseUrl . $link, []);
//            sleep($this->Delay);
//            if ($res->getStatusCode() != 200) log('Неудачный запрос ' . $link);
//            $content23 = $res->getBody()->getContents();
//            $contents23 = json_decode($content23);
//            dd($contents23);

//            $link = '/api/9/items?key=' . $this->key . '&page=' . $page . '&lastStamp=' . $lastStamp . '&display=list&limit=' . $this->Limit . '&url=' . $contents->result->url;
//            $res = $this->client->request('GET', $this->BaseUrl . $link, []);
//            sleep($this->Delay);
//            if ($res->getStatusCode() != 200) log('Неудачный запрос ' . $link);
//            $content = $res->getBody()->getContents();
//            $contents = json_decode($content);
            if ($contents->status != 'ok') {
                throw new \Exception('Авито отклонило запрос  ' . $link);
            } else {
                $count = $contents->result->count;
                if (count($contents->result->items) < $this->Limit) {
                    $more = false;
                }
                foreach ($contents->result->items as $item) {

                    if( $item->type == "vip") continue;
                    if( $item->type == "witcher") continue;
                    if( $item->type == "groupTitle") continue;
                    if( $item->type == "xlItem") continue;
                    $parsingCount++;
                    if($parsingCount > $this->mainCount) break;
                    try {
                        $uri = $item->value->uri_mweb;
                        $tmp_obj = $this->exists($item);
                        if (!$tmp_obj) {
                            $req = $this->client->request('GET', $this->BaseUrl . $uri, []);
                            //dd($this->BaseUrl . $uri);
                            if ($req->getStatusCode() != 200) throw new \Exception('Неудачный запрос ' . $uri);
                            $html = $req->getBody()->getContents();
                            //dd($html);
                            $initial_data = trim(urldecode($this->getInitialData($html)), '"');
                            $data = json_decode($initial_data);
                            //dd($data);
                            if ($data == null) {
                                throw new \Exception("Невалидный JSON на " . $uri);
                            }
                            $obj = $this->generateObject($data);
                            if(!isset($obj->phone)) $obj->phone = "none";
                            $obj->city = $this->getCity($this->LocationId);
                            if(isset($item->value->coords)) {
                                $obj->geo = $item->value->coords->lat .", " . $item->value->coords->lng;
                            } else {
                                $obj->geo = "47.8745, 44.7697";
                            }
                            $obj->area = $item->value->location ?? "";
                            $this->setAddress($obj);
                            dump($obj);
                            $this->a_obj->addObj($obj);
                            sleep($this->Delay);
                        } else {
                            $ao = $this->newFromStd($tmp_obj);
                            if(isset($item->value->coords)) {
                                $ao->geo = $item->value->coords->lat . ", " . $item->value->coords->lng;
                            } else {
                                $ao->geo = "47.8745, 44.7697";
                            }
                            $ao->update();
                        }
                        $parsedCount++;
                    } catch (\Exception $e) {
                        dump($item);
                        dump($link);
                        dump($parsedCount);
                        throw new \Exception("При парсинге объекта " . $uri . ". В строке " . $e->getLine() . " возникла ошибка:  " . $e->getMessage());
                    };
                }
                $page++;
            }

        }

        echo($count . ' ' . $parsedCount);
    }

    private function getPhone($id){
        try {
            $url = "/api/1/items/". $id . "/phone?key=". $this->key;
            $req = $this->client->request('GET', $this->BaseUrl . $url, []);
            if ($req->getStatusCode() != 200) throw new \Exception('Неудачный запрос телефона' . $url);
            $html = $req->getBody()->getContents();
            $json = json_decode($html);
            //dd(substr($json->result->action->uri, -11));
            return substr($json->result->action->uri, -11);
        }catch (\Exception $e) {

        }
    }

    public function newFromStd($std)
    {
        $instance = new \App\Aobject();

        foreach ( (array) $std as $attribute => $value) {
            $instance->{$attribute} = $value;
        }

        return $instance;
    }

    private function exists($item)
    {
        $results = DB::select('select * from aobjects where id = :id', ['id' => $item->value->id]);
        if($results) {
            return $results[0];
        } else {
            return false;
        }

    }

    private function getTags($tag, $xml)
    {
        $tag = preg_quote($tag);
        preg_match_all('{<' . $tag . '[^>]*>(.*?)</' . $tag . '>.}',
            $xml,
            $matches,
            PREG_PATTERN_ORDER);
        return $matches[0];
    }

    private function getKey($xml)
    {
        $re = '/params:{key\:"([^"]+)/m';
        preg_match_all($re, $xml, $matches, PREG_SET_ORDER, 0);
        foreach ($matches as $match) {
            if (strlen($match[1]) > 11)
                return $match[1];
        }

    }

    private function getNumber($xml)
    {
        $re = '/tel:([+0-9]{12})/m';
        preg_match_all($re, $xml, $matches, PREG_SET_ORDER, 0);
        foreach ($matches as $match) {
            if (strlen($match[1]) > 11)
                return $match[1];
        }

    }

    private function setAddress(&$obj) {
        if ($obj->area != "") {
            $loc = trim(preg_replace('/р-н/m', '', $obj->area));
            $re = '/'. $loc .',(.*?)/mU';
            preg_match_all($re, $obj->address, $matches, PREG_SET_ORDER, 0); // Print the entire match result var_dump($matches);
            $obj->address = trim($matches[0][1] ?? $obj->address);
        }
    }

    public function generateObject($initial_data)
    {
        //dump($initial_data);
        $obj = (object)array('id' => $initial_data->item->item->id);
        $obj->title_obj = $initial_data->item->item->title;
        $obj->price = $this->getAllInt($initial_data->item->item->price->value);
        $obj->date = $initial_data->item->item->time;
        $obj->desc = $initial_data->item->item->description;
        $obj->person_name = $initial_data->item->item->seller->name;
        $obj->address = $initial_data->item->item->address;
        $obj->phone = $this->getPhone($initial_data->item->item->id);
//        foreach ($initial_data->item->item->contacts->list as $contact) {
//            if ($contact->type == 'phone') {
//                $obj->phone = stristr($contact->value->uri, 'number=');
//                $obj->phone = preg_replace('/number=/m', '', $obj->phone);
//                $obj->phone = preg_replace('/%2B/m', '+', $obj->phone);
//                break;
//            }
//        }
        $obj->url = $initial_data->item->item->sharing->url;
        $obj->category = $initial_data->item->item->categoryId;
        $title_obj = explode(" ", $obj->title_obj);
        switch ($obj->category) {
            case 25:
                $obj->category = '2';
                $obj->home_square = $this->findParamOnString($obj->title_obj, $obj->category, "home_square");
                $obj->earth_square = $this->findParamOnString($obj->title_obj, $obj->category, "earth_square");
                break;
            case 24:
                if ($title_obj[0] == "Студия,") {
                    $obj->type = "Вторичка";
                    $type = 1;
                } else {
                    $obj->type = "Вторичка";
                    $type = 0;
                }
                $obj->category = '1';
                $obj->square = $this->findParamOnString($obj->title_obj, $obj->category, "square", $type);
                $obj->rooms = $this->findParamOnString($obj->title_obj, $obj->category, "room", $type);
                $obj->floor = $this->findParamOnString($obj->title_obj, $obj->category, "floor", $type);
                $obj->build_floors = $this->findParamOnString($obj->title_obj, $obj->category, "build_floors", $type);
                break;
            case 23:
                $obj->category = '3';
                $obj->type = "";
                $obj->rooms = $this->findParamOnString($obj->title_obj, $obj->category, "room");
                $obj->square = $this->findParamOnString($obj->title_obj, $obj->category, "square");
                $obj->floor = $this->findParamOnString($obj->title_obj, $obj->category, "floor");
                $obj->build_floors = $this->findParamOnString($obj->title_obj, $obj->category, "build_floors");
                break;
            default:
                break;
        }
        $obj->deal = "Продажа";
        foreach ($initial_data->item->item->parameters->flat as $parameter) {
            switch ($parameter->title) {
                case "Тип объявления":
                    $obj->deal = "Продажа";
                    break;
                case "Тип дома":
                    $obj->build_type = $parameter->description;
                    break;
                case "Вид объекта":
                    $obj->type = $parameter->description;
                    break;
                case "Расстояние до города, км":
                    if($parameter->description == "В черте города") {
                        $obj->distance = 0;
                    } else {
                        $obj->distance = $parameter->description;
                    }
                    break;
                case "Материал стен":
                    $obj->build_type = $parameter->description;
                    break;
                case "Этажей в доме":
                    $obj->build_floors = $parameter->description;
                    break;
                default:
                    break;
            }
        }
        if(!isset($obj->distance)) {
            $obj->distance = 0;
        }
        return $obj;
    }

    public function findParamOnString($string, $category, $param, $type = 0)
    {
        $search_build_types = ["кирпичного", "панельного", "блочного", "монолитного", "деревянного"];
        $build_types = ["Кирпичный", "Панельный", "Блочный", "Монолитный", "Деревянный"];
        $search_types = ["дом", "дачу", "коттедж", "таунхаус"];
        $types = ["Дом", "Дача", "Коттедж", "Таунхаус"];
        $search_build_types_2 = ["кирпич", "брус", "бревно", "газоблоки", "металл", "пеноблоки", "сэндвич-панели", "ж/б панели", "экспериментальные материалы"];
        $build_types_2 = ["Кирпич", "Брус", "Бревно", "Металл", "Газоблоки", "Пеноблоки", "Сендвич-панели", "Ж/б панели", "Экспериментальные материалы"];
        switch ($category) {
            case '1':
                switch ($param) {
                    case 'id':
                        return $this->getAllInt($string);
                        break;
                    case 'room':
                        if ($string == "Студия") {
                            return 1;
                        }
                        $room = explode(" ", $string);
                        for ($i = 1; $i < 11; $i++) {
                            if ($room[0] == "$i-к") {
                                return $i;
                            }
                        }
                        break;
                    case 'square':
                        $square = explode(" ", $string);
                        if ($type == 1) {
                            return (int)$square[1];
                        } else {
                            return (int)$square[2];
                        }
                        # code...
                        break;
                    case 'floor':
                        $floor_ = explode(" ", $string);
                        if ($type == 1) {
                            $floor = explode("/", $floor_[3]);
                        } else {
                            $floor = explode("/", $floor_[4]);
                        }
                        return (int)$floor[0];
                        break;
                    case 'build_floors':
                        $floor_ = explode(" ", $string);
                        if ($type == 1) {
                            $floor = explode("/", $floor_[3]);
                        } else {
                            $floor = explode("/", $floor_[4]);
                        }
                        return (int)$floor[1];
                        # code...
                        break;
                    case 'build_type':
                        for ($i = 0; $i < count($search_build_types); $i++) {
                            if (preg_match("~" . $search_build_types[$i] . "~", $string[3 + $type])) {
                                return $build_types[$i];
                            }
                        }
                        # code...
                        break;
                    case "deal":
                        $deal = explode(" ", $string[0]);
                        return $deal[0];
                        break;
                    case "city":
                        $city = explode(",", $string);
                        return trim($city[0]);
                        break;
                    case "area":
                        $area = explode(",", $string);
                        return isset($area[1]) ? trim($area[1]) : "";
                        break;
                    case 'price':
                        return $this->getAllInt($string);
                        # code...
                        break;
                    default:
                        # code...
                        break;
                }
                break;
            case '2':
                switch ($param) {
                    case 'id':
                        return $this->getAllInt($string);
                        break;
                    case 'type':
                        for ($i = 0; $i < count($types); $i++) {
                            if (preg_match("~" . $types[$i] . "~", $string)) {
                                return $types[$i];
                            }
                        }
                        break;
                    case 'home_square':
                        if (preg_match("~\\d* м²~", $string, $matches)) {
                            return $this->getAllInt($matches[0]);
                        }
                        break;
                    case 'earth_square':
                        $sq = explode(" ", $string);
                        return (int)$sq[5];
                        break;
                    case 'build_floors':
                        for ($i = 1; $i < 11; $i++) {
                            if (preg_match("/.*(" . $i . ".*\-этажный|" . $i . "\-этажный).*/", $string[2])) {
                                return $i;
                            }
                        }
                        break;
                    case 'distance':
                        if ($string[5] == ",в черте города") {
                            return 0;
                        } else {
                            return $this->getAllInt($string[5]);
                        }
                        break;
                    case 'build_type':
                        for ($i = 0; $i < count($search_build_types_2); $i++) {
                            if (preg_match("~" . $search_build_types_2[$i] . "~", $string[3])) {
                                return $build_types_2[$i];
                            }
                        }
                        break;
                    case "deal":
                        return $string[0];
                        break;
                    case "city":
                        $city = explode(",", $string);
                        return trim($city[1]);
                        break;
                    case "area":
                        $area = explode(",", $string);
                        return isset($area[2]) ? trim($area[2]) : "";
                        break;
                    case 'price':
                        return $this->getAllInt($string);
                        break;
                    default:
                        break;
                }
                break;
            case '3':
                switch ($param) {
                    case 'id':
                        return $this->getAllInt($string);
                        break;
                    case 'room':
                        $room = explode(" ", $string);
                        for ($i = 1; $i < 11; $i++) {
                            if ($room[4] == "$i-к,") {
                                return $i;
                            }
                        }
                        break;
                    case 'square':
                        $square = explode(" ", $string);
                        return (int)$square[1];
                        # code...
                        break;
                    case 'floor':
                        $floor_ = explode(" ", $string);
                        $floor = explode("/", $floor_[5]);
                        return (int)$floor[0];
                        # code...
                        break;
                    case 'build_floors':
                        $floor_ = explode(" ", $string);
                        $floor = explode("/", $floor_[5]);
                        return (int)($floor[1]??'1');
                        # code...
                        break;
                    case 'build_type':
                        for ($i = 0; $i < count($search_build_types); $i++) {
                            if (preg_match("~" . $search_build_types[$i] . "~", $string)) {
                                return $build_types[$i];
                            }
                        }
                        # code...
                        break;
                    case "deal":
                        $deal = explode(" ", $string[0]);
                        return $deal[0];
                        break;
                    case "city":
                        $city = explode(",", $string);
                        return trim($city[0]);
                        break;
                    case "area":
                        $area = explode(",", $string);
                        return isset($area[1]) ? trim($area[1]) : "";
                        break;
                    case 'price':
                        return $this->getAllInt($string);
                        # code...
                        break;
                    default:
                        # code...
                        break;
                }
                # code...
                break;
            default:
                # code...
                break;
        }
    }



    public function getAllInt($string) {
        $string = preg_replace("/[^0-9]/", '', $string);
        if ($string == "") $string = 0;
        return $string;
    }

    private function getInitialData($xml)
    {
        $re = '/__initialData__ = (.+?\")/m';
        preg_match_all($re, $xml, $matches, PREG_SET_ORDER, 0);
        foreach ($matches as $match) {
            if (strlen($match[1]) > 11)
                return $match[1];
        }

    }

    private function getName($xml)
    {
        $re = '/name\">([А-Яа-я]*)</m';
        preg_match_all($re, $xml, $matches, PREG_SET_ORDER, 0);
        foreach ($matches as $match) {

            return $match[1];
        }

    }

}
