<div class="col-md-12">
    {!! $filter !!}
</div>

<section class="box-typical">
    <header class="box-typical-header">
        <div class="tbl-row">
            <div class="tbl-cell tbl-cell-title" style="padding: 0 !important;">
                {!! Form::select('order', $order_select, $selected, ["onchange" => "window.location.href=this.options[this.selectedIndex].value", "id" => "order", "class" => "custom-select"]) !!}
            </div>
        </div>
    </header>
    <div class="box-typical-body">
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
                @if($objects)
                    @foreach($objects as $object)
                        <tr>
                            <td class="table-obj-a"><div class="tab_content">
                                @if($object->category == 1)
                                    <a href="{{$object->link}}" target="_blank">{{$object->rooms}}-к квартира</a><br>{{$object->square}} м² {{$object->floor}}/{{$object->build_floors}} эт.<br>{{ ($object->date != null)? $object->date->format('d-m-Y'): "" }}
                                @elseif($object->category == 2)
                                    <a href="{{$object->link}}" target="_blank">{{$object->type}}</a><br>{{$object->home_square}} м² на участке {{$object->earth_square}}<br>{{ ($object->date != null)? $object->date->format('d-m-Y'): "" }}
                                @elseif($object->category == 3)
                                    <a href="{{$object->link}}" target="_blank">Комната в {{$object->rooms}}-к</a><br>{{$object->square}} м² {{$object->floor}}/{{$object->build_floors}} эт.<br>{{ ($object->date != null)? $object->date->format('d-m-Y'): "" }}
                                @endif
                                </div>
                            </td>
                            <td class="table-address-a"><div class="tab_content">{{ $object->city }},<br>{{ $object->address }},<br>{{ $object->area }}</div></td>
                            <td><div class="tab_content">{{ number_format($object->price) }}</div></td>
                            <td class="table-desc" style="max-width: 100% !important;"><div class="tab_content">{{ $object->desc }}</div></td>
                            <td class="table-contact-a"><div class="tab_content"><a href="tel:{{$object->client_contacts}}" class="btn btn-success btn-phone col-md-12"><span class="button-text">{{$object->client_contacts}}</span><br><span class="button-text">{{ $object->client_name }}</span></a></div></td>
                            <td width="100"><div class="btn-actions centovka">
                            {!! $actions["object".$object->id] !!}
                         </div>
                    </td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
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
    </div>
</section>
</div>