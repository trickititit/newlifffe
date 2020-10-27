    {!! $filter !!}
    <p>
        <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="true" aria-controls="collapseExample">
            Карта
        </button>
    </p>
    <div class="collapse" id="collapseExample">
        <div id="mapid" style="width: 100%; height: 600px; z-index: 70;"></div>
    </div>
    <ul class="nav nav-tabs">
    @if($menus)
        @include(config('settings.theme').'.admin.objectsMenuItems',['items'=>$menus->roots(), "type" => $type])
    @endif
    </ul>
    <!-- Таблица -->
    <section class="box-typical">
        <header class="box-typical-header">
            <div class="tbl-row">
                <div class="tbl-cell tbl-cell-title" style="padding: 0 !important;">
                    {!! Form::open(["url" => route('object.mass.action'), 'method' => "POST", "id" => "mass_action", "class" => "clearfix", "style" => "float: left;margin: 5px;", "onsubmit" => "massAction()"]) !!}
                    <div class="input-group">
                    {!! Form::select('mass_actions', $mass_actions, "",  ["class" => "form-control form-control-sm"]) !!}
                        <span class="input-group-btn">
                                {!! Form::submit('Выполнить',  ["class" => "btn btn-secondary btn-sm"]) !!}
                          </span>
                    </div>
                    {!! Form::close() !!}
                    {!! Form::select('order', $order_select, $selected, ["onchange" => "window.location.href=this.options[this.selectedIndex].value", "id" => "order", "class" => "custom-select"]) !!}
                </div>
            </div>
        </header>
        <div class="box-typical-body">
            <table class="table table-striped table-bordered table-hover table-sm table-responsive">
                <thead>
                <tr>
                    <th ><div class="checkbox checkbox-only">
                            <input id="check-all" type="checkbox">
                            <label for="check-all"></label>
                        </div></th>
                    <th >Обьект</th>
                    <th >Адрес</th>
                    <th >Цена</th>
                    <th >Описание</th>
                    <th >Доплата</th>
                    @if($type == "outed")
                    <th >Куда выгруженно</th>
                    @else
                    <th >Комментарий</th>
                    @endif
                    <th >Контакты</th>
                    <th >Действия</th>
                </tr>
                </thead>
                <tbody>
                @if($objects)
                    @foreach($objects as $object)
                        <tr>
                            <td class="table-check">
                                <div class="checkbox checkbox-only">
                                    <input class="action-checkbox" name="objects[]" id="tbl-check-{{$object->id}}" type="checkbox" value="{{$object->id}}">
                                    <label for="tbl-check-{{$object->id}}"></label>
                                </div>
                            </td>
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
                            <td class="table-address"><div class="tab_content">{{ $object->address }},<br>{{ str_replace(array("микрорайон", "улица", "Квартал", "квартал", "поселок"), array("мкр", "ул", "кв-л", "кв-л", "п"), isset($object->raion) ? $object->raion->name : "" ) }}, <br> {{ $object->gorod->name }}</div></td>
                            <td><div class="tab_content">{{ number_format($object->price) }}</div></td>
                            <td class="table-desc"><div class="tab_content">{!! $object->desc !!}</div></td>
                            <td><div class="tab_content">{{ number_format($object->surcharge) }}</div></td>
                            @if($type == "outed")
                                <td class="table-comment"><div class="tab_content">
                                        @if($object->out_avito == 1)
                                            <span class="badge badge-success">Авито</span>
                                        @endif
                                        @if($object->out_yandex == 1)
                                            <span class="badge badge-danger">Yandex</span>
                                        @endif
                                        @if($object->out_click == 1)
                                                <span class="badge badge-info">Click</span>
                                        @endif
                                        @if($object->out_all == 1)
                                            <span class="badge badge-primary">All</span>
                                        @endif
                                    </div></td>
                            @else
                                <td class="table-comment"><div class="tab_content">{{ $object->comment }}</div></td>
                            @endif
                            <td class="table-contact"><div class="tab_content">
                                    <a href="{{route('object.phone', ['object'=>$object->alias])}}" data-show="false" data-id="{{$object->id}}" class="btn btn-success btn-phone js-show-phone col-md-12">
                                        <span class="button-text js-name">Показать</span>  <span class="button-text js-father_name"></span><br>
                                        <span class="button-text js-phone"></span>
                                    </a>
                                    @if($object->calls->isNotEmpty() && ($type == 'inwork' || $type == 'prework' || !$object->working_id))
                                        <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#calls-{{$object->id}}">
                                                Звонки
                                            </button>
                                            <!-- Modal -->
                                            <div class="modal fade" id="calls-{{$object->id}}" tabindex="-1" role="dialog" aria-labelledby="calls-{{$object->id}}Label" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="calls-{{$object->id}}Label">Звонки</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            @foreach($object->calls as $call)
                                                                <div class="col-12">
                                                                    <p>
                                                                    @if($call->status)
                                                                        Входящий
                                                                    @else
                                                                        Исходящий
                                                                    @endif
                                                                         {{$call->exec_at->format('Y-m-d H-i-s')}}
                                                                    </p>
                                                                </div>
                                                                <div class="col-12">
                                                                    <audio style="width: 100%" controls preload="none">
                                                                        <source src="{{route('call.get',[ 'data' => $call->exec_at->format('Y-m-d'),'url'=>$call->url])}}" type="audio/mpeg">
                                                                    </audio>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    @endif
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
            <div class="pagina col-md-12">
                <nav>
                    <ul class="pagination pagination-sm centovka">
                        @if($objects->lastPage() > 1)
                            @if($objects->currentPage() !== 1)
                                <li class="page-item"><a class="page-link" href="{{ $objects->url(1) }}">&laquo;</a></li>
                                <li class="page-item"><a class="page-link" href="{{ $objects->url(($objects->currentPage() - 1)) }}">&lsaquo;</a></li>
                            @else
                                <li class="page-item disabled"><a class="page-link">&laquo;</a></li>
                                <li class="page-item disabled"><a class="page-link">&lsaquo;</a></li>
                            @endif
                            @if($objects->lastPage() > 2)
                                @if($objects->currentPage() == 1)
                                    @for($i = 1; $i <= $objects->lastPage() && $i <= 3 ; $i++)
                                        @if($objects->currentPage() == $i)
                                            <li class="page-item active"><a class="page-link">{{ $i }}</a></li>
                                        @else
                                            <li class="page-item"><a class="page-link" href="{{ $objects->url($i) }}">{{ $i }}</a></li>
                                        @endif
                                    @endfor
                                @else
                                    @if($objects->currentPage() == $objects->lastPage())
                                        @for($i = $objects->lastPage() - 2; $i <= $objects->lastPage() ; $i++)
                                            @if($objects->currentPage() == $i)
                                                <li class="page-item active"><a class="page-link">{{ $i }}</a></li>
                                            @else
                                                <li class="page-item"><a class="page-link" href="{{ $objects->url($i) }}">{{ $i }}</a></li>
                                            @endif
                                        @endfor
                                    @else
                                        @for($i = $objects->currentPage() - 1; $i <= $objects->currentPage() + 1 ; $i++)
                                            @if($objects->currentPage() == $i)
                                                <li class="page-item active"><a class="page-link">{{ $i }}</a></li>
                                            @else
                                                <li class="page-item"><a class="page-link" href="{{ $objects->url($i) }}">{{ $i }}</a></li>
                                            @endif
                                        @endfor
                                    @endif
                                @endif
                            @else
                                @for($i = 1; $i <= $objects->lastPage(); $i++)
                                    @if($objects->currentPage() == $i)
                                        <li class="page-item active"><a class="page-link">{{ $i }}</a></li>
                                    @else
                                        <li class="page-item"><a class="page-link" href="{{ $objects->url($i) }}">{{ $i }}</a></li>
                                    @endif
                                @endfor
                            @endif
                            @if($objects->currentPage() !== $objects->lastPage())
                                <li class="page-item"><a class="page-link" href="{{ $objects->url(($objects->currentPage() + 1)) }}">&rsaquo;</a></li>
                                <li class="page-item"><a class="page-link" href="{{ $objects->url($objects->lastPage()) }}">&raquo;</a></li>
                            @else
                                <li class="page-item disabled"><a class="page-link">&rsaquo;</a></li>
                                <li class="page-item disabled"><a class="page-link">&raquo;</a></li>
                            @endif
                        @endif
                    </ul>
                </nav>
            </div>

       </div><!--.box-typical-body-->
    </section>

    <div class="modal fade modal-out"
         tabindex="-1"
         role="dialog"
         aria-labelledby="outModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="modal-close" data-dismiss="modal" aria-label="Закрыть">
                        <i class="font-icon-close-2"></i>
                    </button>
                    <h4 class="modal-title" id="outModalLabel">Выгрузка объекта</h4>
                </div>
                <div class="modal-body">
                    {!! Form::open(["url" => route('object.out',["object" => ""]), "class" => "", 'method' => "post", "id" => "out-form"]) !!}
                    {!! Form::select('target', $inputs["out"], old('target'), ["class" => "form-control", "id" => "target"]) !!}
                    {!! Form::button('Выгрузить', ['class' => 'form-control btn btn-success','type'=>'submit', 'style' => 'margin-top: 15px;']) !!}
                    <input type="hidden" name="_method" value="PUT">
                    {!! Form::close() !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-rounded btn-default" data-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>
    </div><!--.modal-->