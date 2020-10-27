@if($objects->isNotEmpty())
    @if ($objects->count() > 5)
        <div class="col-md-12">
            <div class="sepor"></div>
        </div>
        <div class="col-md-12">
            <div class="title_offer">Специальное предложение:</div>
        </div>
        <div class="col-md-12 offer_margin">
            <div class="slider4">
                @foreach($objects as $object)
                    <div class="slide">
                        <a href='{{route('site.object',['object'=>$object->alias])}}' class="spec_offer">
                            @if($object->images->isNotEmpty())
                                @foreach($object->images as $image)
                                    <div class="img_offer" style="background: url({{ asset(config('settings.theme')) }}/uploads/images/{{$image->object_id}}/{{$image->new_name}} ) no-repeat center center; background-size: cover;">
                                @break
                                @endforeach
                            @else
                                    <div class="img_offer" style="background: url({{ asset(config('settings.theme')) }}/img/no-images.jpg) no-repeat center center; background-size: cover; outline: rgba(0,0,0,.08) solid 1px;">
                            @endif
                            <span>{{$object->spec_offer_span_1}}</span>
                            <span>{{$object->spec_offer_span_2}}</span>

                            </div>
                            <span class="text_offer">
                                @if($object->category == 1)
                                    {{$object->rooms}}-к квартира {{$object->square}} м² {{$object->floor}}/{{$object->build_floors}} эт.
                                @elseif($object->category == 2)
                                    {{$object->type}} {{$object->home_square}} м² на участке {{$object->earth_square}}
                                @elseif($object->category == 3)
                                    Комната в {{$object->rooms}}-к {{$object->square}} м² {{$object->floor}}/{{$object->build_floors}} эт.
                                @endif
                            </span>
                            <span class="text_offer">{{ $object->getViewPrice() }} р.</span>
                            <span class="desc_offer">{{ $object->desc }}</span>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="col-md-12">
            <div class="sepor"></div>
        </div>
        <div class="col-md-12">
            <div class="title_offer">Специальное предложение:</div>
        </div>
        <div class="col-md-12 offer_margin">
            <div class="slider4">
                @foreach($objects as $object)
                <div class="slide" style="float: left; list-style: outside none none; position: relative; width: 200px; margin-right: 10px;">
                        <a href='{{route('site.object',['object'=>$object->alias])}}' class="spec_offer">
                            @if($object->images->isNotEmpty())
                                @foreach($object->images as $image)
                                    <div class="img_offer" style="background: url({{ asset(config('settings.theme')) }}/uploads/images/{{$image->object_id}}/{{$image->new_name}} ) no-repeat center center; background-size: cover;">
                                @break
                                @endforeach
                            @else
                                    <div class="img_offer" style="background: url({{ asset(config('settings.theme')) }}/img/no-images.jpg) no-repeat center center ; background-size: cover;">
                            @endif
                                <span>{{$object->spec_offer_span_1}}</span>
                                <span>{{$object->spec_offer_span_2}}</span>
                                </div>
                            <span class="text_offer">
                                @if($object->category == 1)
                                    {{$object->rooms}}-к квартира {{$object->square}} м² {{$object->floor}}/{{$object->build_floors}} эт.
                                @elseif($object->category == 2)
                                    {{$object->type}} {{$object->home_square}} м² на участке {{$object->earth_square}}
                                @elseif($object->category == 3)
                                    Комната в {{$object->rooms}}-к {{$object->square}} м² {{$object->floor}}/{{$object->build_floors}} эт.
                                @endif
                            </span>
                            <span class="text_offer">{{ $object->getViewPrice() }} р.</span>
                            <span class="desc_offer">{{ $object->desc }}</span>
                        </a>
                </div>
                @endforeach
            </div>
        </div>
    @endif
@endif