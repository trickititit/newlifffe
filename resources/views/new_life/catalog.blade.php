 {!! $filter !!}
 <div id="cat_search_result" class="iziModal"></div>
 <div class="row">
 <div class="col-md-12 order">
 {!! Form::select('order', $order_select ,URL::current(), ["onchange" => "window.location.href=this.options[this.selectedIndex].value", "id" => "order"]) !!}
 </div>
 </div>
@foreach($objects as $object)
    <div class="row catalog_obj">
        <div class="col-md-1">
            {!! $object->images->isEmpty() ? "" : "<i class=\"fa fa-camera fa-lg\"></i>" !!}
        </div>
        <div class="col-md-3">
            @if($object->category == 1)
                <a href="{{route('site.object',['object'=>$object->alias])}}"><div class="catalog_title_obj">{{$object->rooms}}-к квартира </div></a><div class="catalog_date_obj">{{ $object->created_at->format('m/d/Y') }}</div>
            @elseif($object->category == 2)
                <a href="{{route('site.object',['object'=>$object->alias])}}"><div class="catalog_title_obj">{{$object->type}} </div></a><div class="catalog_date_obj">{{ $object->created_at->format('m/d/Y') }}</div>
            @elseif($object->category == 3)
                <a href="{{route('site.object',['object'=>$object->alias])}}"><div class="catalog_title_obj">Комната в {{$object->rooms}}-к </div></a><div class="catalog_date_obj">{{ $object->created_at->format('m/d/Y') }}</div>
            @endif
        </div>
        <div class="col-md-1">
            <div class="catalog_square_obj">
                @if($object->category == 2)
                    {{$object->home_square}} м²
                @else
                    {{$object->square}} м²
                @endif
            </div>
        </div>
        <div class="col-md-1">
            <div class="catalog_floor_obj">
                @if($object->category == 2)
                    на участке {{$object->earth_square}}
                @else
                    {{$object->floor}}/{{$object->build_floors}} эт.
                @endif
            </div>
        </div>
        <div class="col-md-3">
            <div class="catalog_address_obj">{{ $object->gorod->name }},<br>{{ $object->address }},<br>{{ $object->raion->name }}</div>
        </div>
        <div class="col-md-3">
            <div class="catalog_price_obj">{{ $object->price }}</div>
        </div>
    </div>
@endforeach