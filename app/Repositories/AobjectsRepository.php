<?php
/**
 * Created by PhpStorm.
 * User: Трик
 * Date: 10.08.2017
 * Time: 22:14
 */

namespace App\Repositories;
use App\Aobject;


class AobjectsRepository extends Repository
{

    public function __construct(Aobject $object) {
        $this->model = $object;
    }

    public function getToday($type = "4") {
        switch ($type) {
            case '1':
            return $this->model->TodayK()->count();
                break;
            case '2':
            return $this->model->TodayH()->count();
                break;    
            case '3':
            return $this->model->TodayC()->count();
                break;
            default:
            return $this->model->Today()->count();
                break;
        }
    }

    public function getYesterday($type = "4") {
        switch ($type) {
            case '1':
            return $this->model->YesterdayK()->count();
                break;
            case '2':
            return $this->model->YesterdayH()->count();
                break;    
            case '3':
            return $this->model->YesterdayC()->count();
                break;
            default:
            return $this->model->Yesterday()->count();
                break;
        }
    }

    public function getAll($type = "4") {
        switch ($type) {
            case '1':
            return $this->model->K()->count();
                break;
            case '2':
            return $this->model->H()->count();
                break;    
            case '3':
            return $this->model->C()->count();
                break;
            default:
            return $this->model->get()->count();
                break;
        }
    }

    public function addObj($obj){
            if ($this->getOne($obj->id)) {
                return "one";
            } else {
                $this->model = new Aobject();
                switch ($obj->category) {
                    case "1":
                        $this->model->category = $obj->category;
                        $this->model->date = $obj->date;
                        $this->model->id = $obj->id;
                        $this->model->deal = $obj->deal;
                        $this->model->type = $obj->type;
                        $this->model->city = $obj->city;
                        $this->model->area = $obj->area;
                        $this->model->address = $obj->address;
                        $this->model->rooms = $obj->rooms;
                        $this->model->floor = $obj->floor;
                        $this->model->square = $obj->square;
                        $this->model->build_type = $obj->build_type;
                        $this->model->build_floors = $obj->build_floors;
                        $this->model->geo = $obj->geo;
                        $this->model->desc = $obj->desc;
                        $this->model->client_name = $obj->person_name;
                        $this->model->client_contacts = $obj->phone;
                        $this->model->price = $obj->price;
                        $this->model->link = $obj->url;
                        return $this->model->save();
                        break;
                    case "2":
                        $this->model->category = $obj->category;
                        $this->model->date = $obj->date;
                        $this->model->id = $obj->id;
                        $this->model->deal = $obj->deal;
                        $this->model->type = $obj->type;
                        $this->model->city = $obj->city;
                        $this->model->area = $obj->area;
                        $this->model->geo = $obj->geo;
                        $this->model->address = $obj->address;
                        $this->model->distance = $obj->distance;
                        $this->model->home_square = $obj->home_square;
                        $this->model->earth_square = $obj->earth_square;
                        $this->model->build_type = $obj->build_type;
                        $this->model->build_floors = $obj->build_floors;
                        $this->model->desc = $obj->desc;
                        $this->model->client_name = $obj->person_name;
                        $this->model->client_contacts = $obj->phone;
                        $this->model->price = $obj->price;
                        $this->model->link = $obj->url;
                        return $this->model->save();
                        break;
                    case "3":
                        $this->model->category = $obj->category;
                        $this->model->date = $obj->date;
                        $this->model->id = $obj->id;
                        $this->model->deal = $obj->deal;
                        $this->model->type = $obj->type;
                        $this->model->city = $obj->city;
                        $this->model->area = $obj->area;
                        $this->model->geo = $obj->geo;
                        $this->model->address = $obj->address;
                        $this->model->rooms = $obj->rooms;
                        $this->model->floor = $obj->floor;
                        $this->model->square = $obj->square;
                        $this->model->build_type = $obj->build_type;
                        $this->model->build_floors = $obj->build_floors;
                        $this->model->desc = $obj->desc;
                        $this->model->client_name = $obj->person_name;
                        $this->model->client_contacts = $obj->phone;
                        $this->model->price = $obj->price;
                        $this->model->link = $obj->url;
                        return $this->model->save();
                        break;
                    default:
                        break;
                }
            }
    }


    public function searchObject($data, $pagination, $order) {
        if ($order == "pricedesc") {
            $order = array("price", "desc");
        } 
        if (is_array($order)) {
            $query = $this->model->orderBy($order[0], $order[1]);
        } else {
            $query = $this->model->orderBy($order);
        }
        if (!isset($data["price_min"])) {
           $data["price_min"] = 0; 
        } 
        if (!isset($data["price_max"])) {
           $data["price_max"] = 0; 
        }
        switch ($data["category"]) {
            case "1": $square_min = ($data["square_1_min"] == 10)? 1: $data["square_1_min"];
                $square_max = ($data["square_1_max"] == 200)? 99999999: $data["square_1_max"];
                $floor_min = ($data["floor_min"] == 1)? 1: $data["floor_min"];
                $floor_max = ($data["floor_max"] == 31)? 99999: $data["floor_max"];
                $floorInObj_min = ($data["floorInObj_1_min"] == 1)? 1: $data["floorInObj_1_min"];
                $floorInObj_max = ($data["floorInObj_1_max"] == 31)? 999: $data["floorInObj_1_max"];
                $price_min = ($data["price_min"]== 0)? 1: $data["price_min"];
                $price_max = ($data["price_max"]== 0)? 999999999: $data["price_max"];
                $query->whereCategory($data["category"]);
                if (isset($data["deal"])) {
                    $query->whereDeal($data["deal"]);
                }
                if (isset($data["formObj_1"])) {
                    $query->whereType($data["formObj_1"]);
                }
                if (isset($data["city"])) {
                    $query->whereCity($data["city"]);
                }
                if (isset($data["area".$data["city_id"]])) {
                    $query->whereIn("area", $data["area".$data["city_id"]]);
                }
                if (isset($data["typeHouse_1"])) {
                    $query->whereIn("build_type", $data["typeHouse_1"]);
                }
                if (isset($data["room"])) {
                    $query->whereIn("rooms", $data["room"]);
                }      
                if (isset($data["address"])) {
                    $words = mb_strtolower($data["address"]);
                    $words = trim($words);
                    $words = quotemeta($words);
                    $arraywords = explode(" " ,$words);
                    $count = 1;
                    foreach ($arraywords as $word) {
                        if ($count > 1) {
                            $query->orWhere("address", "LIKE", "%$word%");
                        } else {
                            $query->where("address", "LIKE", "%$word%");
                        }
                    }
                }
                $query->where("square", ">=", "$square_min");
                $query->where("square", "<=", "$square_max");
                $query->where("floor", ">=", "$floor_min");
                $query->where("floor", "<=", "$floor_max");
                $query->where("build_floors", ">=", "$floorInObj_min");
                $query->where("build_floors", "<=", "$floorInObj_max");
                $query->where("price", ">=", "$price_min");
                $query->where("price", "<=", "$price_max");      
                break;
            case "2":   $square_min = ($data["square_2_min"] == 10)? 1: $data["square_2_min"];
                $square_max = ($data["square_2_max"] == 500)? 999999999: $data["square_2_max"];
                $square_earth_min = ($data["square_earth_min"] == 1)? 1: $data["square_earth_min"];
                $square_earth_max = ($data["square_earth_max"] == 100)? 9999: $data["square_earth_max"];
                $floorInObj_min = ($data["floorInObj_2_min"] == 1)? 1: $data["floorInObj_2_min"];
                $floorInObj_max = ($data["floorInObj_2_max"] == 5)? 99999: $data["floorInObj_2_max"];
                $distance_min = ($data["distance_min"] == 0)? -1: $data["distance_min"];
                $distance_max = ($data["distance_max"] == 100)? 99999: $data["distance_max"];
                $price_min = ($data["price_min"]== 0)? 1: $data["price_min"];
                $price_max = ($data["price_max"]== 0)? 999999999: $data["price_max"];
                $query->whereCategory($data["category"]);
                if (isset($data["deal"])) {
                    $query->whereDeal($data["deal"]);
                }
                if (isset($data["typeObj_2"])) {
                    $query->whereIn("type", $data["typeObj_2"]);
                }
                if (isset($data["city"])) {
                    $query->whereCity($data["city"]);
                }
                if (isset($data["area".$data["city_id"]])) {
                    $query->whereIn("area", $data["area".$data["city_id"]]);
                }
                if (isset($data["typeHouse_2"])) {
                    $query->whereIn("build_type", $data["typeHouse_2"]);
                }
                if (isset($data["address"])) {
                    $words = mb_strtolower($data["address"]);
                    $words = trim($words);
                    $words = quotemeta($words);
                    $arraywords = explode(" " ,$words);
                    $count = 1;
                    foreach ($arraywords as $word) {
                        if ($count > 1) {
                            $query->orWhere("address", "LIKE", "%$word%");
                        } else {
                            $query->where("address", "LIKE", "%$word%");
                        }
                    }
                }
                $query->where("home_square", ">=", "$square_min");
                $query->where("home_square", "<=", "$square_max");
                $query->where("earth_square", ">=", "$square_earth_min");
                $query->where("earth_square", "<=", "$square_earth_max");
                $query->where("distance", ">=", "$distance_min");
                $query->where("distance", "<=", "$distance_max");
                $query->where("build_floors", ">=", "$floorInObj_min");
                $query->where("build_floors", "<=", "$floorInObj_max");
                $query->where("price", ">=", "$price_min");
                $query->where("price", "<=", "$price_max");
                break;
            case "3":   $square_min = ($data["square_1_min"] == 10)? 1: $data["square_1_min"];
                $square_max = ($data["square_1_max"] == 200)? 99999999: $data["square_1_max"];
                $floor_min = ($data["floor_min"] == 1)? 1: $data["floor_min"];
                $floor_max = ($data["floor_max"] == 31)? 99999: $data["floor_max"];
                $floorInObj_min = ($data["floorInObj_1_min"] == 1)? 1: $data["floorInObj_1_min"];
                $floorInObj_max = ($data["floorInObj_1_max"] == 31)? 999: $data["floorInObj_1_max"];
                $price_min = ($data["price_min"]== 0)? 1: $data["price_min"];
                $price_max = ($data["price_max"]== 0)? 999999999: $data["price_max"];
                $query->whereCategory($data["category"]);
                if (isset($data["deal"])) {
                    $query->whereDeal($data["deal"]);
                }
                if (isset($data["formObj_3"])) {
                    $query->whereType($data["formObj_3"]);
                }
                if (isset($data["city"])) {
                    $query->whereCity($data["city"]);
                }
                if (isset($data["area".$data["city_id"]])) {
                    $query->whereIn("area", $data["area".$data["city_id"]]);
                }
                if (isset($data["typeHouse_1"])) {
                    $query->whereIn("build_type", $data["typeHouse_1"]);
                }
                if (isset($data["room"])) {
                    $query->whereIn("rooms", $data["room"]);
                }
                if (isset($data["address"])) {
                    $words = mb_strtolower($data["address"]);
                    $words = trim($words);
                    $words = quotemeta($words);
                    $arraywords = explode(" " ,$words);
                    $count = 1;
                    foreach ($arraywords as $word) {
                        if ($count > 1) {
                            $query->orWhere("address", "LIKE", "%$word%");
                        } else {
                            $query->where("address", "LIKE", "%$word%");
                        }
                    }
                }
                $query->where("square", ">=", "$square_min");
                $query->where("square", "<=", "$square_max");
                $query->where("floor", ">=", "$floor_min");
                $query->where("floor", "<=", "$floor_max");
                $query->where("build_floors", ">=", "$floorInObj_min");
                $query->where("build_floors", "<=", "$floorInObj_max");
                $query->where("price", ">=", "$price_min");
                $query->where("price", "<=", "$price_max");
                break;
            default:
                break;
        }
        return $query->paginate($pagination);
    }

    public function getOne($id) {
        return $this->model->find(intval($id));
    }

    public function whereOne($id) {
        return $this->model->where("id", "=", $id)->first();
    }
}