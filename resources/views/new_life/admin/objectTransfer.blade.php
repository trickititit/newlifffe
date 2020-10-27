<section class="box-typical box-panel">
    <header class="box-typical-header">
        <div class="tbl-row">
            <div class="tbl-cell tbl-cell-title">
                <h3 id="h3-create-obj">Трансфер объекта</h3> <button id="upload-img" class="btn btn-primary clearfix" data-toggle="modal" data-target="#myModal">
                    Загрузить изображения
                </button>
            </div>
        </div>
    </header>
    <div class="box-typical-body">
        {!! Form::open(["url" => route('aobject.store'), "class" => "form-wizard", 'method' => "POST", "id" => "objCreate"]) !!}
        <div>
            <section>
                {!! $obj_param !!}
                <input id="obj_type" type="hidden" name="obj_type" value="{{ isset($object->category) ? $object->category  : (isset($category) ? $category : old('obj_type'))}}">
                <input type="hidden" name="obj_form_1" value="{{isset($object->category) ? (($object->category == 1) ? $object->type : ""): (isset($type) ? $type : old('obj_form_1'))}}">
                <input type="hidden" name="obj_form_2" value="{{isset($object->category) ? (($object->category == 2) ? $object->type : ""): (isset($type) ? $type : old('obj_form_2'))}}">
                @if($object->category == 3)
                    <div id="obj_form_3" class="form-group row">
                        <div id="obj_form_3">
                            <label class="col-sm-2 form-control-label" for="obj_form_3">Тип комнаты</label>
                            <div class="col-sm-10 col-md-4">
                                <p class="form-control-static">{!! Form::select('obj_form_3', $inputs["obj_form_3"], $object->type, ["class" => "form-control"]) !!}</p>
                            </div>
                        </div>
                    </div>
                @endif
                <div id="obj_deal" class="form-group row">
                    <div id="obj_deal">
                        <label class="col-sm-2 form-control-label" for="obj_deal">Тип сделки</label>
                        <div class="col-sm-10 col-md-4">
                            <p class="form-control-static">{!! Form::select('obj_deal', $inputs["obj_deal"], $object->deal, ["class" => "form-control"]) !!}</p>
                        </div>
                    </div>
                </div>
		<div id="obj_city" class="form-group row">
                    <label for="obj_type" class="col-sm-2 form-control-label">Город</label>
                    <div class="col-sm-10 col-md-4">
                        <p class="form-control-static">{!! Form::select('obj_city', $inputs["obj_city"],  $object->city, ["class" => "form-control"]) !!}</p>
                    </div>
                </div>
                <div id="obj_area" class="form-group row">
                    @foreach($cities as $city)
                        @if($city->name == 'Волжский')
                            <div id="obj_area{{$city->id}}">
                                <label class="col-sm-2 form-control-label" for="obj_area{{$city->id}}">Район</label>
                                <div class="col-sm-10 col-md-4">
                                    <p class="form-control-static">{!! Form::select('obj_area'.$city->id, $inputs["obj_area".$city->id], $object->area, ["class" => "form-control"]) !!}</p>
                                </div>
                            </div>
                        @else
                            <div id="obj_area{{$city->id}}" style="display: none;">
                                <label class="col-sm-2 form-control-label" for="obj_area{{$city->id}}">Район</label>
                                <div class="col-sm-10 col-md-4">
                                    <p class="form-control-static">{!! Form::select('obj_area'.$city->id, $inputs["obj_area".$city->id], $object->area, ["class" => "form-control"]) !!}</p>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
                <div class="form-group">
                </div>
                <div class="col-md-12">
                    <h4 class="m-t-md">Настройки</h4>
                    <div class="col-md-12">
                        <div class="checkbox-bird">
                            {!! Form::checkbox('spec_offer', "1", (isset($object->spec_offer) ? true : false) , ["id" => "spec_offer"]) !!}
                            <label for="spec_offer">Специальное предложение</label>
                        </div>
                    </div>
                    <div class="form-group clearfix" id="spec_offer_input" {{ isset($object->spec_offer) ? "" : "style=display:none;"  }}>
                        <div class="col-md-4">
                            <fieldset class="form-group">
                                <label class="form-label semibold" for="client_family">Поле Специального предложения 1</label>
                                {!! Form::text('spec_offer_span_1', isset($object->spec_offer_span_1)? $object->spec_offer_span_1 : old("spec_offer_span_1"), ["id" => "spec_offer_span_1" ,"class" => "form-control"]) !!}
                            </fieldset>
                        </div>
                        <div class="col-md-4">
                            <fieldset class="form-group">
                                <label class="form-label semibold" for="client_father_name">Поле Специального предложения 2</label>
                                {!! Form::text('spec_offer_span_2', isset($object->spec_offer_span_2)? $object->spec_offer_span_2 : old("spec_offer_span_2"), ["id" => "spec_offer_span_2" ,"class" => "form-control"]) !!}
                            </fieldset>
                        </div>
                    </div>
                </div>
            </section>
            <h3>Адрес</h3>
            <section>
                <div id="search_address" class="form-group">
                    <div class="hero-unit">
                        <div class="row-fluid">
                            <div id="adr-search" class="form-search">
                                <div class="control-group">
                                    <div class="input-group">
                                        <input name="search-query" type="text" class="form-control" id="search-query" placeholder="Что искать...">
                                        <span class="input-group-btn">
                                                            <button id="search-map" class="btn btn-secondary" type="submit">Найти</button>
                                                          </span>
                                    </div>
                                    <span class="help-inline invisible">Пожалуйста исправьте ошибку в этом поле</span>
                                </div>
                            </div>
                        </div>
                        <div class="row-fluid">
                            <div id="HereMap"></div>
                        </div>
                    </div>
                    {!! Form::hidden('obj_geo', isset($object->geo)? $object->geo: old("obj_geo"), ["id" => "obj_geo"]) !!}
                    <div id="address form-group" class="form-group row">
                        <label for="obj_address" class="col-sm-2 form-control-label">Адрес</label>
                        <div class="col-sm-10">
                            <p class="form-control-static">{!! Form::text('obj_address', isset($object->address)? $object->address : old("obj_address"), ['id'=>'obj_address', "class" => "form-control", 'aria-describedby'=>'adrHelp', "required" => ""]) !!}<small id="adrHelp" class="form-text text-muted">Можно поменять сформировавшийся адрес.</small></p>
                        </div>
                    </div>
                </div>
            </section>
            <section>
                <div id="cat-1" {{isset($object->category)? (($object->category == 2) ? "style=display:none;" : "") : ($category == 2) ? "style=display:none;": ""}}>
                    <div id="room" class="form-group row">
                        <label for="obj_room" class="col-sm-2 form-control-label">Количество комнат</label>
                        <div class="col-sm-10">
                            <div class="btn-group" data-toggle="buttons">
                                @foreach($inputs["obj_room"] as $value => $input)
                                    <label class="btn {{isset($object->rooms)? (($object->rooms == $value) ?  "active" : "") : ""}}">
                                        <input type="radio" {{isset($object->rooms)? (($object->rooms == $value) ?  "checked" : "") : ""}} name="obj_room" value="{{$value}}" id="option{{$value}}" autocomplete="off"> {{$input}}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div id="build_type_1" class="form-group row">
                        <label for="obj_build_type_1" class="col-sm-2 form-control-label">Тип дома</label>
                        <div class="col-sm-10">
                            <div class="btn-group" data-toggle="buttons">
                                @foreach($inputs["obj_build_type_1"] as $value => $input)
                                    <label class="btn {{isset($object->build_type)? (($object->build_type == $value) ?  "active" : "") : ""}}">
                                        <input {{isset($object->build_type)? (($object->build_type == $value) ?  "checked" : "") : ""}} type="radio" name="obj_build_type_1" value="{{$value}}" id="option{{$value}}" autocomplete="off"> {{$input}}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div id="floor" class="form-group row">
                        <label for="obj_floor" class="col-sm-2 form-control-label">Этаж</label>
                        <div class="col-sm-10">
                            <div class="btn-group" data-toggle="buttons">
                                @foreach($inputs["obj_floor"] as $value => $input)
                                    <label class="btn {{isset($object->floor)? (($object->floor == $value) ?  "active" : "") : ""}}">
                                        <input {{isset($object->floor)? (($object->floor == $value) ?  "checked" : "") : ""}} type="radio" name="obj_floor" value="{{$value}}" id="option{{$value}}" autocomplete="off"> {{$input}}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div id="home_floors_1" class="form-group row">
                        <label for="obj_home_floors_1" class="col-sm-2 form-control-label">Этажей в доме</label>
                        <div class="col-sm-10">
                            <div class="btn-group" data-toggle="buttons">
                                @foreach($inputs["obj_home_floors_1"] as $value => $input)
                                    <label class="btn {{isset($object->build_floors)? (($object->build_floors == $value) ?  "active" : "") : ""}}">
                                        <input {{isset($object->build_floors)? (($object->build_floors == $value) ?  "checked" : "") : ""}} type="radio" name="obj_home_floors_1" value="{{$value}}" id="option{{$value}}" autocomplete="off"> {{$input}}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div id="square">
                        <div class="form-group row">
                            <label for="obj_square_general" class="col-sm-2 form-control-label">Общая площадь</label>
                            <div class="col-sm-10">
                                <div class="col-md-2">
                                    <div class="input-group">
                                        {!! Form::text('obj_square', isset($object->square)? $object->square : old("obj_square_general"), ["class" => "form-control money-mask-input", "id" => "square_general", "required" => ""]) !!}
                                        <div class="input-group-addon">
                                            <span>м²</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="btn-group" data-toggle="buttons" id="square_general_radio">
                                        @foreach($inputs["obj_general_square"] as $value => $input)
                                            <label class="btn">
                                                <input type="radio" value="{{$value}}" id="option{{$value}}" > {{$input}}
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="obj_square_kitchen" class="col-sm-2 form-control-label">Площадь кухни</label>
                            <div class="col-sm-10">
                                <div class="col-md-2">
                                    <div class="input-group">
                                        {!! Form::text('obj_square_kitchen', isset($object->square_kitchen)? $object->square_kitchen : old("obj_square_kitchen"), ["class" => "form-control money-mask-input", "id" => "square_kitchen", "required" => ""]) !!}
                                        <div class="input-group-addon">
                                            <span>м²</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="btn-group" data-toggle="buttons" id="square_kitchen_radio">
                                        @foreach($inputs["obj_square_kitchen"] as $value => $input)
                                            <label class="btn">
                                                <input type="radio" value="{{$value}}" id="option{{$value}}" > {{$input}}
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="obj_square_life" class="col-sm-2 form-control-label">Жилая площадь</label>
                            <div class="col-sm-10">
                                <div class="col-md-2">
                                    <div class="input-group">
                                        {!! Form::text('obj_square_life', isset($object->square_life)? $object->square_life : old("obj_square_life"), ["class" => "form-control money-mask-input", "id" => "square_life", "required" => ""]) !!}
                                        <div class="input-group-addon">
                                            <span>м²</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="btn-group" data-toggle="buttons" id="square_life_radio">
                                        @foreach($inputs["obj_square_life"] as $value => $input)
                                            <label class="btn">
                                                <input type="radio" value="{{$value}}" id="option{{$value}}" > {{$input}}
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="cat-2" {{isset($object->category)? (($object->category != 2) ? "style=display:none;" : "") : ($category != 2) ? "style=display:none;": ""}}>
                    <div id="home_floors_2" class="form-group row">
                        <label for="obj_home_floors_2" class="col-sm-2 form-control-label">Этажей в доме</label>
                        <div class="col-sm-10">
                            <div class="btn-group" data-toggle="buttons">
                                @foreach($inputs["obj_home_floors_2"] as $value => $input)
                                    <label class="btn {{isset($object->build_floors)? (($object->build_floors == $value) ?  "active" : "") : ""}}">
                                        <input {{isset($object->build_floors)? (($object->build_floors == $value) ?  "checked" : "") : ""}} type="radio" name="obj_home_floors_2" value="{{$value}}" id="option{{$value}}" autocomplete="off"> {{$input}}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div id="build_type_2" class="form-group row">
                        <label for="obj_build_type_2" class="col-sm-2 form-control-label">Тип дома</label>
                        <div class="col-sm-10">
                            <div class="btn-group" data-toggle="buttons">
                                @foreach($inputs["obj_build_type_2"] as $value => $input)
                                    <label class="btn {{isset($object->build_type)? (($object->build_type == $value) ?  "active" : "") : ""}}">
                                        <input {{isset($object->build_type)? (($object->build_type == $value) ?  "checked" : "") : ""}} type="radio" name="obj_build_type_2" value="{{$value}}" id="option{{$value}}" autocomplete="off"> {{$input}}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div id="distance" class="form-group row">
                        <label for="obj_distance" class="col-sm-2 form-control-label">Расстояние до города</label>
                        <div class="col-sm-10">
                            <div class="btn-group" data-toggle="buttons">
                                @foreach($inputs["obj_distance"] as $value => $input)
                                    <label class="btn {{isset($object->distance)? (($object->distance == $value) ?  "active" : "") : ""}}">
                                        <input {{isset($object->distance)? (($object->distance == $value) ?  "checked" : "") : ""}} type="radio" name="obj_distance" value="{{$value}}" id="option{{$value}}" autocomplete="off"> {{$input}}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div id="house_square" class="form-group row">
                        <label for="obj_house_square" class="col-sm-2 form-label semibold">Площадь дома</label>
                        <div class="col-sm-10 col-md-2">
                            <div class="input-group">
                                {!! Form::text('obj_house_square', isset($object->home_square)? $object->home_square : old("obj_house_square"), ["class" => "form-control money-mask-input", "required" => ""]) !!}
                                <div class="input-group-addon">
                                    <span>м²</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="earth_square" class="form-group row">
                        <label for="obj_earth_square" class="col-sm-2 form-label semibold">Площадь участка</label>
                        <div class="col-sm-10 col-md-2">
                            <div class="input-group">
                                {!! Form::text('obj_earth_square', isset($object->earth_square)? $object->earth_square : old("obj_earth_square"), ["class" => "form-control money-mask-input", "required" => ""]) !!}
                                <div class="input-group-addon">
                                    <span>сот.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div >
                    <h4 class="m-t-md">Удобства</h4>
                    <div>
                        <div id="comforts-no-border" class="no-border">
                            @foreach($comforts as $comfort)
                                {!! Form::checkbox('comfort[]', $comfort->title) !!}
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
            <section>
                <div id="desc" class="form-group row" style="margin-top: 20px;">
                    <label for="obj_desc" class="col-sm-2 form-control-label">Описание</label>
                    <div class="col-sm-10">
                        <p class="form-control-static">{!! Form::textarea('obj_desc', isset($object->desc) ? $object->desc  : old('obj_desc'), ['class' => 'form-control','placeholder'=>'Введите Описание', "cols" => "40", "rows" => "6"]) !!}</p>
                    </div>
                </div>
                <div id="comment" class="form-group row">
                    <label for="obj_comment" class="col-sm-2 form-control-label">Комментарий</label>
                    <div class="col-sm-10">
                        <p class="form-control-static">{!! Form::textarea("obj_comment", isset($object->comment) ? $object->comment  : old('obj_comment'), ['class' => 'form-control','placeholder'=>'Введите Комментарий', "cols" => "40", "rows" => "3"]) !!}
                        </p>
                    </div>
                </div>
                <div id="price_square" class="form-group row">
                    <label for="obj_price_square" class="col-sm-2 form-label semibold">Цена за м²</label>
                    <div class="col-sm-10 col-md-4">
                        <div class="form-control-wrapper form-control-icon-right">
                            {!! Form::text('obj_price_square', isset($object->price) ? (($object->category == 2) ? round($object->price / (($object->home_square > 0)? $object->home_square : 1)) : round($object->price / (($object->square > 0)? $object->square : 1))) : old("obj_price_square"), ["class" => "form-control money-mask-input", "readonly" => ""]) !!}
                            <i class="glyphicon glyphicon-ruble"></i>
                        </div>
                    </div>
                </div>
                <div id="price" class="form-group row">
                    <label for="obj_price" class="col-sm-2 form-label semibold">Цена</label>
                    <div class="col-sm-10 col-md-4">
                        <div class="form-control-wrapper form-control-icon-right">
                            {!! Form::text('obj_price', isset($object->price)? $object->price : old("obj_price"), ["class" => "form-control money-mask-input", "required" => ""]) !!}
                            <i class="glyphicon glyphicon-ruble"></i>
                        </div>
                    </div>
                </div>
                <div id="doplata" class="form-group row">
                    <label for="obj_doplata" class="col-sm-2 form-label semibold">Доплата</label>
                    <div class="col-sm-10 col-md-4">
                        <div class="form-control-wrapper form-control-icon-right">
                            {!! Form::text('obj_doplata', isset($object->surcharge)? $object->surcharge : old("obj_doplata"), ["class" => "form-control money-mask-input", "required" => ""]) !!}
                            <i class="glyphicon glyphicon-ruble"></i>
                        </div>
                    </div>
                </div>
            </section>
            <h3>Клиент</h3>
            <section>
                <div class="col-md-4">
                    <fieldset class="form-group">
                        <label class="form-label semibold" for="client_name">Имя</label>
                        {!! Form::text('client_name', isset($object->client_name)? $object->client_name : old("client_name"), ["id" => "client_name" ,"class" => "form-control", "required" => ""]) !!}
                    </fieldset>
                </div>
                <div class="col-md-4">
                    <fieldset class="form-group">
                        <label class="form-label semibold" for="client_family">Фамилия</label>
                        {!! Form::text('client_family', isset($object->client->family)? $object->client->family : old("client_family"), ["id" => "client_family" ,"class" => "form-control"]) !!}
                    </fieldset>
                </div>
                <div class="col-md-4">
                    <fieldset class="form-group">
                        <label class="form-label semibold" for="client_father_name">Отчество</label>
                        {!! Form::text('client_father_name', isset($object->client->father_name)? $object->client->father_name : old("client_father_name"), ["id" => "client_father_name" ,"class" => "form-control"]) !!}
                    </fieldset>
                </div>
                <div class="col-md-12">
                    <div id="accordion" role="tablist" aria-multiselectable="true">
                        <div class="card">
                            <div class="card-header" role="tab" id="headingOne">
                                <h5 style="margin-bottom: 0;">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Данные
                                    </a>
                                </h5>
                            </div>

                            <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne">
                                <div class="card-block">
                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <label class="form-label semibold" for="client_place">Место рождения</label>
                                            {!! Form::text('client_place', isset($object->client->place)? $object->client->place : old("client_place"), ["id" => "client_place" ,"class" => "form-control"]) !!}
                                        </fieldset>
                                    </div>
                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <label class="form-label semibold" for="client_date">Дата рождения</label>
                                            {!! Form::text('client_date', isset($object->client->date)? $object->client->date : old("client_date"), ["id" => "client_date" ,"class" => "form-control date-mask-input"]) !!}
                                        </fieldset>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="client_phone" class="form-label semibold">Телефон</label>
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <span>+7</span>
                                                </div>
                                                {!! Form::text('client_phone', isset($object->client_contacts)? $object->client_contacts : old("client_phone"), ["id" => "client_phone" ,"class" => "form-control phone-mask-input",  "required" => ""]) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <label class="form-label semibold" for="client_mail">E-mail</label>
                                            {!! Form::email('client_mail', isset($object->client->mail)? $object->client->mail : old("client_mail"), ["id" => "client_mail" ,"class" => "form-control"]) !!}
                                        </fieldset>
                                    </div>
                                    <h5 class="m-t-lg with-border">Паспорт</h5>
                                    <div class="col-md-4">
                                        <fieldset class="form-group">
                                            <label class="form-label semibold" for="client_pasport">Серия, Номер</label>
                                            {!! Form::text('client_pasport', isset($object->client->pasport)? $object->client->pasport : old("client_pasport"), ["id" => "client_pasport" ,"class" => "form-control pasport-mask-input"]) !!}
                                        </fieldset>
                                    </div>
                                    <div class="col-md-4">
                                        <fieldset class="form-group">
                                            <label class="form-label semibold" for="client_pasport_who_take">Кем выдан</label>
                                            {!! Form::text('client_pasport_who_take', isset($object->client->pasport_who_take)? $object->client->pasport_who_take : old("client_pasport_who_take"), ["id" => "client_pasport_who_take" ,"class" => "form-control"]) !!}
                                        </fieldset>
                                    </div>
                                    <div class="col-md-4">
                                        <fieldset class="form-group">
                                            <label class="form-label semibold" for="client_pasport_date">Когда выдан</label>
                                            {!! Form::text('client_pasport_date', isset($object->client->pasport_date)? $object->client->pasport_date : old("client_pasport_date"), ["id" => "client_pasport_date" ,"class" => "form-control date-mask-input"]) !!}
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="need">
                    <h5 class="m-t-lg with-border">Что нужно клиенту</h5>
                    <div class="form-group row" style="margin-top: 20px;">
                        <label for="obj_desc" class="col-sm-2 form-control-label">Объекты</label>
                        <div class="col-sm-10">
                            <p class="form-control-static">
                                {!! Form::select('client_need[]', $inputs["client_need"],  isset($object->client->need) ? $object->client->need  : old('client_need'), ["class" => "chosen-select form-control", 'data-placeholder'=>'Выберите требуемое', 'multiple' => ""]) !!}
                            </p>
                        </div>
                    </div>
                </div>
            </section>

        </div>
        {!! Form::hidden('obj_id', isset($object->id)? $object->id: old("obj_id", $obj_id)) !!}
        <button type="submit" class="btn btn-success">Перенести</button>
        {!! Form::close() !!}
    </div><!--.box-typical-body-->
</section>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Загрузка изображений</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(["url" => route("adminObjUplImg"), "class" => "dropzone", 'method' => "POST", "id" => "my-dropzone"]) !!}
                {!! Form::hidden('obj_id', isset($object->id)? $object->id: old("obj-id", $obj_id), ["id" => "obj-id"]) !!}
                {!! Form::hidden('tmp_img', 1, ["id" => "tmp-img"]) !!}
                {!! Form::close() !!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>