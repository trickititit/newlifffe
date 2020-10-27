{{-- // @TODO: сделать Popovers--}}
<div id="filter">
    {!! Form::open(["url" => URL::current(), 'method' => "GET"]) !!}
        <div class="row bg_top">
            <div class="col-md-12 top_filter">
                {!! Form::select('category', $inputs["obj_category"], isset($data["category"]) ? $data["category"]  : old('category'), ["id" => "type"]) !!}
                {!! Form::text('address', isset($data["address"])? $data["address"] : old("address"), ['id'=>'adr', "placeholder" => "Адрес"]) !!}
                {!! Form::select('city', $inputs["cities"], isset($data["city"])? $data["city"] : 2, ["id" => "city"]) !!}
                @foreach($cities as $city)
                    @if($city->id == 2)
                        {!! Form::text('', isset($data["value_area".$city->id])? $data["value_area".$city->id] : old("amount-area_".$city->id, "Район"), ["id" => "amount-area_".$city->id, "readonly" => "", "data-popover" => "true", "data-popover-content" => ".area_".$city->id."_search",  "data-checkbox" => "true", "data-show" => "true"]) !!}
                    @else
                        {!! Form::text('', isset($data["value_area".$city->id])? $data["value_area".$city->id] : old("amount-area_".$city->id, "Район"), ["id" => "amount-area_".$city->id, "readonly" => "", "style" => "display: none;", "data-popover" => "true", "data-popover-content" => ".area_".$city->id."_search", "data-checkbox" => "true", "data-show" => "true"]) !!}
                    @endif
                    <div class="area_{{$city->id}}_search hidden">
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
                <input id="submit_search" name="search" type="submit" value="Найти" />
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 dop_select">
                {!! Form::select('deal', $inputs["obj_deal"], isset($data["deal"]) ? $data["deal"] : old('deal'), ["id" => "typedeal"]) !!}
                {!! Form::text('', isset($data["value_rooms"])? $data["value_rooms"] : "Количество комнат", ['id'=>'amount-rooms', "readonly" => "", "data-popover" => "true", "data-popover-content" => ".rooms_search", "data-slider-id" => "room", "data-checkbox" => "true"]) !!}
                <div class="rooms_search hidden">
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
                {!! Form::select('formObj_3', $inputs["obj_form_3"], isset($data["formObj_3"]) ? $data["formObj_3"] : old('formObj_3'), ["id" => "formObj_3", "style" => "display: none;"]) !!}
                {!! Form::text('', isset($data["value_typeObj_2"])? $data["value_typeObj_2"] : "Вид обьекта", ['id'=>'amount-formObj_2', "readonly" => "", "style" => "display: none;", "data-popover" => "true", "data-popover-content" => ".formObj_2_search", "data-show" => "true", "data-checkbox" => "true"]) !!}
                <div class="formObj_2_search hidden">
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
                <input type="text" id="amount-square_2" readonly data-popover = "true" data-popover-content = "#square_2_search" data-slider-id = "square_2" style="display: none;">
                <!-- Поля для поиска -->
                <input type="number" id="amount-square_2_min" readonly name="square_2_min" hidden>
                <input type="number"  id="amount-square_2_max" readonly name="square_2_max" hidden>
                <div id="square_2_search" class="hidden">
                    <div id="slider-range-square_2"></div>
                </div>
                {!! Form::select('formObj_1', $inputs["obj_form_1"], isset($data["formObj_1"]) ? $data["formObj_1"] : old('formObj_1'), ["id" => "formObj_1"]) !!}
                <input type="text" id="amount-square_1" data-popover = "true" data-popover-content = "#square_1_search" data-slider-id = "square_1" readonly >
                <!-- Поля для поиска -->
                <input type="number" id="amount-square_min" readonly name="square_1_min" hidden>
                <input type="number" id="amount-square_max" readonly name="square_1_max" hidden>
                <div id="square_1_search" class="hidden">
                    <div id="slider-range-square_1"></div>
                </div>
                <input type="text" id="amount-square_earth" readonly data-popover = "true" data-popover-content = "#square_earth_search" data-slider-id = "square_earth" style="display: none;">
                <!-- Поля для поиска -->
                <input type="number" id="amount-square_earth_min" readonly name="square_earth_min" hidden>
                <input type="number" id="amount-square_earth_max" readonly name="square_earth_max" hidden>
                <div id="square_earth_search" class="hidden">
                    <div id="slider-range-square_earth"></div>
                </div>
                {!! Form::select('rieltor', $inputs["rieltors"], isset($data["rieltor"]) ? $data["rieltor"] : old('rieltor'), ["id" => "rieltor"]) !!}
                {{--<select id="rieltors" name="rieltor"><option value="">Риелтор</option><option value="1">Ольга</option><option value="2">Станислав</option><option value="3">Инесса</option><option value="4">Ольга</option><option value="5">vova</option><option value="7">fallo</option><option value="9">addon</option><option value="10">addon1</option><option value="11">asdddddd</option></select>--}}
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 dop_select">
                <input type="text" id="amount-floor" readonly  data-popover = "true" data-popover-content = "#floor_search" data-slider-id = "floor">
                <!-- Поля для поиска -->
                <input type="number" id="amount-floor_min" readonly name="floor_min" hidden>
                <input type="number" id="amount-floor_max" readonly name="floor_max" hidden>
                <div id="floor_search" class="hidden">
                    <div id="slider-range-floor"></div>
                </div>
                <input type="text" id="amount-floorInObj_2" readonly data-popover = "true" data-popover-content = "#floorInObj_2_search" data-slider-id = "floorInObj_2" style="display: none;">
                <!-- Поля для поиска -->
                <input type="number" id="amount-floorInObj_2_min" readonly name="floorInObj_2_min" hidden>
                <input type="number" id="amount-floorInObj_2_max" readonly name="floorInObj_2_max" hidden>
                <div id="floorInObj_2_search" class="hidden">
                    <div id="slider-range-floorInObj_2"></div>
                </div>
                <input type="text" id="amount-floorInObj_1" data-popover = "true" data-popover-content = "#floorInObj_1_search" data-slider-id = "floorInObj_1" readonly>
                <!-- Поля для поиска -->
                <input type="number" id="amount-floorInObj_1_min"  readonly name="floorInObj_1_min" hidden>
                <input type="number" id="amount-floorInObj_1_max" readonly name="floorInObj_1_max" hidden>
                <div id="floorInObj_1_search" class="hidden">
                    <div id="slider-range-floorInObj_1"></div>
                </div>
                {!! Form::text('', isset($data["value_typeHouse_2"])? $data["value_typeHouse_2"] : "Материал стен", ['id'=>'amount-typeHouse_2', "readonly" => "", "style" => "display: none;", "data-popover" => "true", "data-popover-content" => ".typeHouse_2_search", "data-show" => "true", "data-checkbox" => "true"]) !!}
                <div class="typeHouse_2_search hidden">
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
                {!! Form::text('', isset($data["value_typeHouse_1"])? $data["value_typeHouse_1"] : "Тип дома", ['id'=>'amount-typeHouse_1', "readonly" => "", "data-popover" => "true", "data-popover-content" => ".typeHouse_1_search", "data-show" => "true", "data-checkbox" => "true"]) !!}
                <div class="typeHouse_1_search hidden">
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
                <input type="text" id="amount-distance" readonly data-popover = "true" data-popover-content = "#distance_search" data-slider-id = "distance" style="display: none;">
                <!-- Поля для поиска -->
                <input type="number" id="amount-distance_min" readonly name="distance_min" hidden>
                <input type="number" id="amount-distance_max" readonly name="distance_max" hidden>
                <div id="distance_search" class="hidden">
                    <div id="slider-range-distance"></div>
                </div>
                <input type="text" id="amount-price" readonly value="Цена, руб" data-popover = "true" data-popover-content = ".price_search" data-show = "true" data-checkbox = "true">
                <div class="price_search hidden">
                    {!! Form::number('price_min', isset($data["price_min"])? $data["price_min"] : old("price_min"), ['class'=>'min-price', "placeholder" => "от"]) !!}
                    <span style="float: left;">-</span>
                    {!! Form::number('price_max', isset($data["price_max"])? $data["price_max"] : old("price_max"), ['class'=>'max-price', "placeholder" => "до"]) !!}
                </div>
                <label id="photo"><table><tr><td><input type="checkbox" name="photo" /></td><td id="label_checkbox">только с фото</td></tr></table></label>
            </div>
        </div>
    {!! Form::close()!!}
</div>
