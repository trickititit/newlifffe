<div class="box-typical box-typical-padding">
        <h1>Избранное</h1>
    <section class="tabs-section">
        <div class="tabs-section-nav tabs-section-nav-icons">
            <div class="tbl">
                <ul class="nav" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" href="#tabs-2-tab-1" role="tab" data-toggle="tab" aria-expanded="true">
                                    <span class="nav-link-in">
                                        Новая жизнь
                                    </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#tabs-2-tab-2" role="tab" data-toggle="tab" aria-expanded="false">
                                    <span class="nav-link-in">
                                        Авито
                                    </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div><!--.tabs-section-nav-->

        <div class="tab-content">
            <div role="tabpanel" class="tab-pane fade in active show" id="tabs-2-tab-1" aria-expanded="true">
                <!-- Таблица -->
                <table class="table table-striped table-bordered table-hover table-sm">
                    <thead>
                    <tr>
                        <th >Обьект</th>
                        <th >Адрес</th>
                        <th >Цена</th>
                        <th >Описание</th>
                        <th >Доплата</th>
                        <th >Комментарий</th>
                        <th >Контакты</th>
                        <th >Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($favorites)
                        @foreach($favorites as $object)
                            <tr>
                                <td class="table-obj"><div class="tab_content">
                                        @if($object->category == 1)
                                            <a href="{{route('site.object',['object'=>$object->alias])}}">{{$object->rooms}}-к квартира</a><br>{{$object->square}} м² {{$object->floor}}/{{$object->build_floors}} эт.<br>{{ $object->created_at->format('d/m/Y') }}
                                        @elseif($object->category == 2)
                                            <a href="{{route('site.object',['object'=>$object->alias])}}">{{$object->type}}</a><br>{{$object->home_square}} м² на участке {{$object->earth_square}}<br>{{ $object->created_at->format('d/m/Y') }}
                                        @elseif($object->category == 3)
                                            <a href="{{route('site.object',['object'=>$object->alias])}}">Комната в {{$object->rooms}}-к</a><br>{{$object->square}} м² {{$object->floor}}/{{$object->build_floors}} эт.<br>{{ $object->created_at->format('d/m/Y') }}
                                        @endif
                                    </div>
                                </td>
                                <td class="table-address"><div class="tab_content">{{ $object->address }},<br>{{ str_replace(array("микрорайон", "улица", "Квартал", "квартал", "поселок"), array("мкр", "ул", "кв-л", "кв-л", "п"), $object->raion->name) }}, <br> {{ $object->gorod->name }}</div></td>
                                <td><div class="tab_content">{{ number_format($object->price) }}</div></td>
                                <td class="table-desc"><div class="tab_content">{{ $object->desc }}</div></td>
                                <td><div class="tab_content">{{ number_format($object->surcharge) }}</div></td>
                                <td class="table-comment"><div class="tab_content">{{ $object->comment }}</div></td>
                                <td class="table-contact"><div class="tab_content">
                                        <a href="{{route('object.phone', ['object'=>$object->alias])}}" data-show="false" data-id="{{$object->id}}" class="btn btn-success btn-phone js-show-phone col-md-12">
                                            <span class="button-text js-name">Показать</span>  <span class="button-text js-father_name"></span><br>
                                            <span class="button-text js-phone"></span>
                                        </a>
                                    </div></td>
                                <td class="table-actions"><div class="tab_content"><div class="btn-actions centovka">
                                            {!! $actions["object".$object->id] !!}
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div><!--.tab-pane-->
            <div role="tabpanel" class="tab-pane fade" id="tabs-2-tab-2" aria-expanded="false">
                <table class="table table-striped table-bordered table-hover table-sm table-responsive">
                    <thead>
                    <tr>
                        <th >Обьект</th>
                        <th >Адрес</th>
                        <th >Цена</th>
                        <th >Описание</th>
                        <th >Контакты</th>
                        <th >Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                        @if($a_favorites)
                            @foreach($a_favorites as $object)
                                <tr>
                                    <td class="table-obj-a"><div class="tab_content">
                                            @if($object->category == 1)
                                                <a href="{{$object->link}}" target="_blank">{{$object->rooms}}-к квартира</a><br>{{$object->square}} м² {{$object->floor}}/{{$object->build_floors}} эт.<br>{{ ($object->date != null)? $object->date->format('m-d-Y H:i'): "" }}
                                            @elseif($object->category == 2)
                                                <a href="{{$object->link}}" target="_blank">{{$object->type}}</a><br>{{$object->home_square}} м² на участке {{$object->earth_square}}<br>{{ ($object->date != null)? $object->date->format('m-d-Y H:i'): "" }}
                                            @elseif($object->category == 3)
                                                <a href="{{$object->link}}" target="_blank">Комната в {{$object->rooms}}-к</a><br>{{$object->square}} м² {{$object->floor}}/{{$object->build_floors}} эт.<br>{{ ($object->date != null)? $object->date->format('m-d-Y H:i'): "" }}
                                            @endif
                                        </div>
                                    </td>
                                    <td class="table-address-a"><div class="tab_content">{{ $object->city }},<br>{{ $object->address }},<br>{{ $object->area }}</div></td>
                                    <td><div class="tab_content">{{ number_format($object->price) }}</div></td>
                                    <td class="table-desc" style="max-width: 100% !important;"><div class="tab_content">{{ $object->desc }}</div></td>
                                    <td class="table-contact-a"><div class="tab_content">{{$object->client_contacts}} - {{ $object->client_name }}</div></td>
                                    <td width="100"><div class="btn-actions centovka">
                                            {!! $actions["object".$object->id] !!}
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
            </div><!--.tab-pane-->
        </div><!--.tab-content-->
    </section>
</div>