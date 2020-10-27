<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ObjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $category = $this->request->get("obj_type");
        switch ($category) {
            case "1":
                return [
                    'obj_deal' => 'required|max:190',
                    'obj_form_1' => 'required|max:190',
                    'obj_city' => 'required|max:190',
                    'obj_address' => 'required|max:190',
                    'obj_room' => 'required|integer',
                    'obj_floor' => 'required|integer',
                    'obj_square' => 'required|integer',
                    'obj_square_kitchen' => 'required|integer',
                    'obj_square_life' => 'required|integer',
                    'obj_build_type_1' => 'required|max:190',
                    'obj_home_floors_1' => 'required|integer',
                    'obj_desc' => 'required',
                    'obj_price_square' => 'required',
                    'obj_price' => 'required',
                    'obj_doplata' => 'required',
                    'obj_geo' => 'required',
                    'client_name' => 'required',
                    'client_phone' => 'required',
                ];
                break;
            case "2":
                return [
                    'obj_deal' => 'required|max:190',
                    'obj_form_2' => 'required|max:190',
                    'obj_city' => 'required|max:190',
                    'obj_address' => 'required|max:190',
                    'obj_house_square' => 'required|integer',
                    'obj_distance' => 'required|integer',
                    'obj_earth_square' => 'required|integer',
                    'obj_build_type_2' => 'required|max:190',
                    'obj_home_floors_2' => 'required|integer',
                    'obj_desc' => 'required',
                    'obj_price_square' => 'required',
                    'obj_price' => 'required',
                    'obj_doplata' => 'required',
                    'obj_geo' => 'required',
                    'client_name' => 'required',
                    'client_phone' => 'required',
                ];
                break;
            case "3":
                return [
                    'obj_deal' => 'required|max:190',
                    'obj_form_3' => 'required|max:190',
                    'obj_city' => 'required|max:190',
                    'obj_address' => 'required|max:190',
                    'obj_room' => 'required|integer',
                    'obj_floor' => 'required|integer',
                    'obj_square' => 'required|integer',
                    'obj_square_kitchen' => 'required|integer',
                    'obj_square_life' => 'required|integer',
                    'obj_build_type_1' => 'required|max:190',
                    'obj_home_floors_1' => 'required|integer',
                    'obj_desc' => 'required',
                    'obj_price_square' => 'required',
                    'obj_price' => 'required',
                    'obj_doplata' => 'required',
                    'obj_geo' => 'required',
                    'client_name' => 'required',
                    'client_phone' => 'required',
                ];
                break;
            default:
                break;
        }
    }

    public function messages()
    {
        return [
            'obj_floor.required' => 'Выберите Этаж',
            'obj_build_type_1.required'  => 'Выберите Тип дома',
            'obj_home_floors_1.required'  => 'Выберите сколько этажей в доме',
            'obj_square_kitchen.required'  => 'Выберите площадь кухни',
            'obj_room.required'  => 'Выберите количество комнат',
            'obj_square.required'  => 'Выберите общую площадь',
            'obj_square_life.required'  => 'Выберите жилую площадь',
            'obj_geo.required'  => 'Найдите обьект на карте',
            'obj_address.required'  => 'Введите адрес',
            'obj_distance.required'  => 'Выберите дистанцию до города',
            'obj_build_type_2.required'  => 'Выберите тип дома',
            'obj_home_floors_2.required'  => 'Выберите количество этажей в доме',
            'obj_earth_square.required'  => 'Выберите площадь дома',
            'obj_desc.required'  => 'Введите описание',
            'obj_price_square.required'  => 'Цена за m2 обязательно для заполнения',
        ];
    }
}
