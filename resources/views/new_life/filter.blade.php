{{-- // @TODO: сделать Popovers--}}
<div id="catalog_filter">
    {!! Form::open(["url" => URL::current(), 'method' => "GET"]) !!}

        <div class="col-md-12 cat_row">
            <div class="col-md-3">
            {!! Form::select('category', $inputs["obj_category"], isset($data["category"]) ? $data["category"]  : old('category'), ["id" => "cat_type"]) !!}
            </div>
            <div class="col-md-3">
            {!! Form::select('city', $inputs["cities"], isset($data["city"])? $data["city"] : 2, ["id" => "cat_city"]) !!}
            </div>
            <div class="col-md-3">
            @foreach($cities as $city)
                @if($city->id == 2)
                    {!! Form::text('', isset($data["value_area".$city->id])? $data["value_area".$city->id] : old("amount-area_".$city->id, "Район"), ["id" => "cat_amount-area_".$city->id, "readonly" => ""]) !!}
                @else
                    {!! Form::text('', isset($data["value_area".$city->id])? $data["value_area".$city->id] : old("amount-area_".$city->id, "Район"), ["id" => "cat_amount-area_".$city->id, "readonly" => "", "style" => "display: none;"]) !!}
                @endif
                <div id="cat_area_{{$city->id}}_search" style="display: none;">
                    @if(isset($data["area".$city->id]))
                        @foreach($city->areas as $area)
                            @set($check, 0)
                            @foreach($data["area".$city->id] as $key => $value)
                                @if($area->id == $value)
                                    @set($check, 1)
                                    @break
                                @endif
                            @endforeach
                            @if($check == 1)
                                <label>{!! Form::checkbox('area'.$city->id.'[]', $area->id, true) !!}{{$area->name}}</label>
                            @else
                                <label>{!! Form::checkbox('area'.$city->id.'[]', $area->id) !!}{{$area->name}}</label>
                            @endif
                        @endforeach
                    @else
                        @foreach($city->areas as $area)
                            <label>{!! Form::checkbox('area'.$city->id.'[]', $area->id) !!}{{$area->name}}</label>
                        @endforeach
                    @endif
                </div>
            @endforeach
            </div>
            <div class="col-md-3">
                {!! Form::select('deal', $inputs["obj_deal"], isset($data["deal"]) ? $data["deal"] : old('deal'), ["id" => "cat_typedeal"]) !!}
            </div>
            </div>
            <div class="col-md-12 cat_row">
                <div class="col-md-10">
                    {!! Form::text('address', isset($data["address"])? $data["address"] : old("address"), ['id'=>'cat_adr', "placeholder" => "Адрес"]) !!}
                </div>
                <div class="col-md-2">
                    <button id="cat_submit_search" name="search" type="submit" value="Найти" >Найти</button>
                </div>
            </div>
    <div id="dop_cat_filter" style = "display: none;">
    <div class="col-md-12 cat_row">
        <div class="col-md-3">
            {!! Form::select('formObj_1', $inputs["obj_form_1"], isset($data["formObj_1"]) ? $data["formObj_1"] : old('formObj_1'), ["id" => "cat_formObj_1"]) !!}
            {!! Form::select('formObj_3', $inputs["obj_form_3"], isset($data["formObj_3"]) ? $data["formObj_3"] : old('formObj_3'), ["id" => "cat_formObj_3", "style" => "display: none;"]) !!}
            {!! Form::text('', isset($data["value_typeObj_2"])? $data["value_typeObj_2"] : "Вид обьекта", ['id'=>'cat_amount-formObj_2', "readonly" => "", "style" => "display: none;"]) !!}
            <div id="cat_formObj_2_search" style="display: none;">
                @if(isset($data["typeObj_2"]))
                    @foreach($inputs["obj_form_2"] as $key => $value)
                        @set($check, 0)
                        @foreach($data["typeObj_2"] as $key_ => $value_)
                            @if($value == $value_)
                                @set($check, 1)
                                @break
                            @endif
                        @endforeach
                        @if($check == 1)
                            <label>{!! Form::checkbox('typeObj_2[]', $value, true, ["id" => "typeObj_2-$key"]) !!}{{$value}}</label>
                        @else
                            <label>{!! Form::checkbox('typeObj_2[]', $value, null, ["id" => "typeObj_2-$key"]) !!}{{$value}}</label>
                        @endif
                    @endforeach
                @else
                    @foreach($inputs["obj_form_2"] as $key => $value)
                        <label>{!! Form::checkbox('typeObj_2[]', $value, null, ["id" => "typeObj_2-$key"]) !!}{{$value}}</label>
                    @endforeach
                @endif
            </div>
        </div>
        <div class="col-md-3">
            {!! Form::text('', isset($data["value_rooms"])? $data["value_rooms"] : "Количество комнат", ['id'=>'cat_amount-rooms', "readonly" => ""]) !!}
            <div id="cat_rooms_search" style="display: none;">
                <fieldset>
                    @if(isset($data["room"]))
                        @foreach($inputs["obj_room"] as $key => $value)
                            @set($check, 0)
                            @foreach($data["room"] as $key_ => $value_)
                                @if($value == $value_)
                                    @set($check, 1)
                                    @break
                                @endif
                            @endforeach
                            @if($check == 1)
                                <label for="checkbox-{{$key}}">{{$value}}</label>
                                {!! Form::checkbox('room[]', $value, true, ["id" => "checkbox-$key"]) !!}
                            @else
                                <label for="checkbox-{{$key}}">{{$value}}</label>
                                {!! Form::checkbox('room[]', $value, null, ["id" => "checkbox-$key"]) !!}
                            @endif
                        @endforeach
                    @else
                        @foreach($inputs["obj_room"] as $key => $value)
                            <label for="checkbox-{{$key}}">{{$value}}</label>
                            {!! Form::checkbox('room[]', $value, null, ["id" => "checkbox-$key"]) !!}
                        @endforeach
                    @endif
                </fieldset>
            </div>
            <input type="text" id="cat_amount-square_2" readonly style="display: none;">
            <!-- Поля для поиска -->
            <input type="number" id="cat_amount-square_2_min" readonly name="square_2_min" hidden>
            <input type="number"  id="cat_amount-square_2_max" readonly name="square_2_max" hidden>
            <div id="cat_square_2_search" style="display: none;">
                <div id="cat_slider-range-square_2"></div>
            </div>
        </div>
        <div class="col-md-3">
            <input type="text" id="cat_amount-square_1" readonly >
            <!-- Поля для поиска -->
            <input type="number" id="cat_amount-square_min" readonly name="square_1_min" hidden>
            <input type="number" id="cat_amount-square_max" readonly name="square_1_max" hidden>
            <div id="cat_square_1_search" style="display: none;">
                <div id="cat_slider-range-square_1"></div>
            </div>
            <input type="text" id="cat_amount-square_earth" readonly style="display: none;">
            <!-- Поля для поиска -->
            <input type="number" id="cat_amount-square_earth_min" readonly name="square_earth_min" hidden>
            <input type="number" id="cat_amount-square_earth_max" readonly name="square_earth_max" hidden>
            <div id="cat_square_earth_search" style="display: none;">
                <div id="cat_slider-range-square_earth"></div>
            </div>
        </div>
        <div class="col-md-3">
            <input type="text" id="cat_amount-floor" readonly >
            <!-- Поля для поиска -->
            <input type="number" id="cat_amount-floor_min" readonly name="floor_min" hidden>
            <input type="number" id="cat_amount-floor_max" readonly name="floor_max" hidden>
            <div id="cat_floor_search" style="display: none;">
                <div id="cat_slider-range-floor"></div>
            </div>
            <input type="text" id="cat_amount-floorInObj_2" readonly style="display: none;">
            <!-- Поля для поиска -->
            <input type="number" id="cat_amount-floorInObj_2_min" readonly name="floorInObj_2_min" hidden>
            <input type="number" id="cat_amount-floorInObj_2_max" readonly name="floorInObj_2_max" hidden>
            <div id="cat_floorInObj_2_search" style="display: none;">
                <div id="cat_slider-range-floorInObj_2"></div>
            </div>
        </div>
            {{--<select id="rieltors" name="rieltor"><option value="">Риелтор</option><option value="1">Ольга</option><option value="2">Станислав</option><option value="3">Инесса</option><option value="4">Ольга</option><option value="5">vova</option><option value="7">fallo</option><option value="9">addon</option><option value="10">addon1</option><option value="11">asdddddd</option></select>--}}
        </div>
    <div class="col-md-12 cat_row">
        <div class="col-md-3">
            <input type="text" id="cat_amount-floorInObj_1" readonly>
            <!-- Поля для поиска -->
            <input type="number" id="cat_amount-floorInObj_1_min"  readonly name="floorInObj_1_min" hidden>
            <input type="number" id="cat_amount-floorInObj_1_max" readonly name="floorInObj_1_max" hidden>
            <div id="cat_floorInObj_1_search" style="display: none;">
                <div id="cat_slider-range-floorInObj_1"></div>
            </div>
            {!! Form::text('', isset($data["value_typeHouse_2"])? $data["value_typeHouse_2"] : "Материал стен", ['id'=>'cat_amount-typeHouse_2', "readonly" => "", "style" => "display: none;"]) !!}
            <div id="cat_typeHouse_2_search" style="display: none;">
                @if(isset($data["typeHouse_2"]))
                    @foreach($inputs["obj_build_type_2"] as $key => $value)
                        @set($check, 0)
                        @foreach($data["typeHouse_2"] as $key_ => $value_)
                            @if($value == $value_)
                                @set($check, 1)
                                @break
                            @endif
                        @endforeach
                        @if($check == 1)
                            <label>{!! Form::checkbox('typeHouse_2[]', $value, true, ["id" => "typeHouse_2-$key"]) !!}{{$value}}</label>
                        @else
                            <label>{!! Form::checkbox('typeHouse_2[]', $value, null, ["id" => "typeHouse_2-$key"]) !!}{{$value}}</label>
                        @endif
                    @endforeach
                @else
                    @foreach($inputs["obj_build_type_2"] as $key => $value)
                        <label>{!! Form::checkbox('typeHouse_2[]', $value, null, ["id" => "typeHouse_2-$key"]) !!}{{$value}}</label>
                    @endforeach
                @endif
            </div>
        </div>
        <div class="col-md-3">
            {!! Form::text('', isset($data["value_typeHouse_1"])? $data["value_typeHouse_1"] : "Тип дома", ['id'=>'cat_amount-typeHouse_1', "readonly" => ""]) !!}
            <div id="cat_typeHouse_1_search" style="display: none;">
                @if(isset($data["typeHouse_1"]))
                    @foreach($inputs["obj_build_type_1"] as $key => $value)
                        @set($check, 0)
                        @foreach($data["typeHouse_1"] as $key_ => $value_)
                            @if($value == $value_)
                                @set($check, 1)
                                @break
                            @endif
                        @endforeach
                        @if($check == 1)
                            <label>{!! Form::checkbox('typeHouse_1[]', $value, true, ["id" => "typeHouse_1-$key"]) !!}{{$value}}</label>
                        @else
                            <label>{!! Form::checkbox('typeHouse_1[]', $value, null, ["id" => "typeHouse_1-$key"]) !!}{{$value}}</label>
                        @endif
                    @endforeach
                @else
                    @foreach($inputs["obj_build_type_1"] as $key => $value)
                        <label>{!! Form::checkbox('typeHouse_1[]', $value, null, ["id" => "typeHouse_1-$key"]) !!}{{$value}}</label>
                    @endforeach
                @endif
            </div>
            <input type="text" id="cat_amount-distance" readonly style="display: none;">
            <!-- Поля для поиска -->
            <input type="number" id="cat_amount-distance_min" readonly name="distance_min" hidden>
            <input type="number" id="cat_amount-distance_max" readonly name="distance_max" hidden>
            <div id="cat_distance_search" style="display: none;">
                <div id="cat_slider-range-distance"></div>
            </div>
        </div>
        <div class="col-md-3">
            <input type="text" id="cat_amount-price" readonly value="Цена, руб">
            <div id="cat_price_search" style="display: none;">
                {!! Form::number('price_min', isset($data["price_min"])? $data["price_min"] : old("price_min"), ['id'=>'cat_min-price', "placeholder" => "от"]) !!}
                <span style="float: left;">-</span>
                {!! Form::number('price_max', isset($data["price_max"])? $data["price_max"] : old("price_max"), ['id'=>'cat_max-price', "placeholder" => "до"]) !!}
            </div>
        </div>
    </div>
    </div>
    <div class="col-md-12">
        <div class="cat_slide" show="0"><span>Подробный поиск</span></div>
    </div>
    {!! Form::close()!!}
</div>
