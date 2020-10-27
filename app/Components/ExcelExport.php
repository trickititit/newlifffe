<?php
/**
 * Created by PhpStorm.
 * User: Трик
 * Date: 15.05.2017
 * Time: 22:43
 */
namespace App\Components;

use Excel;

class ExcelExport {

    public $count = array(
        '0' => 2
    , '1' => 2
    , '2' => 2
    , '3' => 2
    , '4' => 2
    , '5' => 2
    );

    public function Export ($objects, $login) {
        $path = storage_path('app/public/'.env('THEME','default').'/xlsx/clear.xlsx');
        $excel = Excel::load($path);
        $excel->setFilename($login);
        $excel->setTitle('Our new awesome title');

        // Our second sheet
        $this->setWidth($excel, "Комнаты");
        $this->setWidth($excel, "Однушки");
        $this->setWidth($excel, "Двушки");
        $this->setWidth($excel, "Трешки");
        $this->setWidth($excel, "Четырешки");
        $this->setWidth($excel, "Дома");
        foreach ($objects as $object) {
            $object->client = json_decode($object->client);
        }
        for($i = 0; $i < $objects->count(); $i++) {
            $object_use = $this->formatObject($objects[$i]);
            switch ($objects[$i]->category) {
                case "1":
                    switch ($objects[$i]->rooms) {
                        case "1":   $this->setSheetContent($excel, "Однушки", $object_use, 1);
                            break;
                        case "2":   $this->setSheetContent($excel, "Двушки", $object_use, 2);
                            break;
                        case "3":   $this->setSheetContent($excel, "Трешки", $object_use, 3);
                            break;
                        default:    $this->setSheetContent($excel, "Четырешки", $object_use, 4);
                            break;
                    }
                    break;
                case "2":   $this->setSheetContent($excel, "Дома", $object_use, 5);
                    break;
                case "3":   $this->setSheetContent($excel, "Комнаты", $object_use, 0);
                    break;
                default:
                    break;
            }
        }
        // Border tables by sheet
        foreach( $this->count as $id => $c ) {
                $excel->setActiveSheetIndex($id)
                ->getStyle( 'A1:H'.($c-1) )
                ->getAlignment()->setWrapText(true);
        }
        $excel->setActiveSheetIndex(1);
        $excel->store('xlsx', storage_path('app/public/'.env('THEME','default').'/xlsx/'));
    }

    public function setWidth( $excel, $name_sheet) {
        $excel->sheet($name_sheet, function ($sheet) {
            $sheet->setAutoSize(true);
            $sheet->setWidth('A', 10);
            $sheet->setWidth('B', 15);
            $sheet->setWidth('C', 10);
            $sheet->setWidth('D', 33);
            $sheet->setWidth('E', 10);
            $sheet->setWidth('F', 33);
            $sheet->setWidth('G', 20);
            $sheet->setWidth('H', 10);
        });
    }
    
    public function setSheetContent($excel ,$sheet_name, $object, $obj_type) {
        $excel->sheet($sheet_name, function ($sheet) use ($object, $obj_type) {
            $sheet->row($this->count[$obj_type], array($object["area"], $object["street"], $object["price"], $object["desc"], $object["surcharge"], $object["comment"], $object["contact"], $object["date"]));

            $sheet->setHeight($this->count[$obj_type], 50);
        });
        $this->count[$obj_type]++;
    }

    public function formatObject($object){
        // Field Area
        $object_ = array();
        $area = $object->raion->name ?? "";
        $area = str_replace( 'микрорайон', 'мкр.', $area);
        $area = str_replace( 'Квартал', 'Кв-л', $area);
        $object_ = array_add($object_, "area", $area);

        // Field Street
        $street = ($object->address ?? "") ."  " . ($object->floor ?? "") . "/" . ($object->build_floors ?? "") . " этаж, " . ($object->square ?? "") . " м²";
        $street_h = ($object->address ?? "") ."  " . ($object->build_floors ?? "") . " этаж, " . ($object->home_square ?? "") . " м²";
        if ($object->category == 2) {
            $object_ = array_add($object_, "street", $street_h);
        } else {
            $object_ = array_add($object_, "street", $street);
        }

        // Field Price
        $price = number_format( $object->price ?? "" );
        $object_ = array_add($object_, "price", $price);

        // Field Desc
        $desc = strip_tags( $object->desc ?? "" );
        $object_ = array_add($object_, "desc", $desc);

        // Field Doplata
        $surcharge = number_format( $object->surcharge ?? "" );
        $object_ = array_add($object_, "surcharge", $surcharge);

        // Field Comments
        $comm = strip_tags( $object->comment ?? "" );
        $object_ = array_add($object_, "comment", $comm);

        // Field Contacts
        $cont = strip_tags( ($object->client->name ?? "") . "   " . ($object->client->phone ?? ""));
        $object_ = array_add($object_, "contact", $cont);

        // Field Date
        $date = $object->created_at->format('Y-m-d');
        $object_ = array_add($object_, "date", $date);

        return $object_;
    }

}