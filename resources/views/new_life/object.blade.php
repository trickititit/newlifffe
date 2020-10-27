<div id="content">
    <div class="col-md-9 col-sm-12 no-padding">
    <div class="col-md-2 obj-icon">
        <img class="center" src="{{ asset(config('settings.theme')) }}/img/svg/{{$obj_image}}">
    </div>
    <div class="col-md-7">
        <div class="col-md-12 title_view">
             {{$object->address}}. {{ $title }}
        </div>
        <div class="col-md-12 time_view">
            Размещено {{ $object->created_at }}
        </div>
    </div>
    <div class="col-md-3">
        <span class="price_view">{{ $object->getViewPrice() }} р.</span>
    </div>
    {!! $gallery !!}
    @if($object->comforts->isNotEmpty())
        <div class="col-md-12">
            <div class="block_content" style="width: 100%;">
            @foreach($object->comforts as $comfort)
                <div class="comfort">
                    <i class="fa fa-check-square-o"></i>
                    {{ $comfort->title }}
                </div>
            @endforeach
            </div>
        </div>
    @else
        <div class="col-md-12">
        </div>
    @endif
    <div class="col-md-9">
        <div class="block_content obj-desc clearfix" style="width: 100%;">
            <span>{!!  $object->desc !!}</span>
        </div>
    </div>
    <div class="col-md-3">
        <div class="block_content" style="width: 100%;">
            <div class="rietor-avatar">
                @if($object->working_id)
                    @if(isset($object->workingUser->image))
                        <img class="center img-circle" src="{{ asset(config('settings.theme')) }}/uploads/avatar/avatar-{{$object->workingUser->id}}-128{{$object->workingUser->image}}">
                    @else
                        <img class="center" src="{{ asset(config('settings.theme')) }}/img/avatar-1-128.png">
                    @endif
                @else
                    @if(isset($object->createdUser->image))
                        <img class="center img-circle" src="{{ asset(config('settings.theme')) }}/uploads/avatar/avatar-{{$object->createdUser->id}}-128{{$object->createdUser->image}}">
                    @else
                        <img class="center" src="{{ asset(config('settings.theme')) }}/img/avatar-1-128.png">
                    @endif
                @endif
            </div>
            <div class="rieltor-name">
                <span>{{$object->working_id ? $object->workingUser->name : $object->createdUser->name}}</span>
            </div>
            <div class="rieltor-call">
                <a href="tel:{{preg_replace("/[^,.0-9]/", '', $object->working_id ? $object->workingUser->telefon : $object->createdUser->telefon) }}" class="btn btn-success">Позвонить <br>{{ $object->working_id ? $object->workingUser->telefon : $object->createdUser->telefon }}</a>
                {{--<button class="btn btn-success">Написать</button>--}}
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="row-fluid">
            <div id="YMapsID" class="span8"></div>
        </div>
    </div>
    </div>
    <div class="col-md-3 col-sm-12 no-padding">
        <div class="col-md-12">
            <div class="other-title">Похожие:</div>
            @foreach($other as $object)
                <div class="other-block">
                    <a href='{{route('site.object',['object'=>$object->alias])}}' class="spec_offer">
                        @if($object->images->isNotEmpty())
                            @foreach($object->images as $image)
                                <div class="img_offer" style="background: url({{ asset(config('settings.theme')) }}/uploads/images/{{$image->object_id}}/{{$image->new_name}} ) no-repeat center center; background-size: cover;">
                                    @break
                                    @endforeach
                                    @else
                                        <div class="img_offer" style="background: url({{ asset(config('settings.theme')) }}/img/no-images.jpg) no-repeat center center ; background-size: cover; outline: rgba(0,0,0,.08) solid 1px;">
                                            @endif
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
                                        <span class="desc_offer">{!! mb_strimwidth($object->desc, 0, 100, "...") !!}</span>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>

<div id="modal-send-telegram" class="iziModal" data-izimodal-title="Связаться">
    <div class="modern-forms">
        <div class="modern-container">
            {!! Form::open(["url" => '', 'method' => "POST", "id" => "form-telegram"]) !!}
            <fieldset>
                <div class="form-row">
                    <div class="col col-6">
                        <div class="field-group prepend-icon">
                            <input name="name" type="text" class="mdn-input" placeholder="Введите ваше имя">
                            <label class="mdn-label">Имя</label>
                            <span class="mdn-icon"><i class="fa fa-male"></i></span>
                            <span class="mdn-bar"></span>
                        </div>
                    </div><!-- end col-6 -->
                    <div class="col col-6">
                        <div class="field-group prepend-icon">
                            <input name="mail" type="email" class="mdn-input" placeholder="Введите Email">
                            <label class="mdn-label">Email</label>
                            <span class="mdn-icon"><i class="fa fa-envelope"></i></span>
                            <span class="mdn-bar"></span>
                        </div>
                    </div><!-- end col-6 -->
                </div><!-- end form-row -->
                <div class="field-group prepend-icon">
                    <input name="phone" type="text" class="mdn-input" placeholder="Введите номер телефона">
                    <label class="mdn-label">Телефон</label>
                    <span class="mdn-icon"><i class="fa fa-phone"></i></span>
                    <span class="mdn-bar"></span>
                </div>
            </fieldset>
            <fieldset>
                <div class="field-group">
                    <textarea name="message" class="mdn-textarea" placeholder="Введите сообщение"></textarea>
                    <label class="mdn-label">Ваше сообщение</label>
                    <span class="mdn-bar"></span>
                </div><!-- end mdn-group -->
            </fieldset>
            <input hidden name="user_id" value="{{$object->working_id ?? $object->created_id}}">
            <input hidden name="obj_id" value="{{$object->id}}">
            <div class="mdn-footer">
                <button type="submit" class="mdn-button btn-primary">Отправить</button>
                <button type="reset" class="mdn-button btn-flat">Сбросить</button>
            </div>
            {!! Form::close() !!}
        </div><!-- modern-container -->
    </div><!-- modern-forms -->
</div>