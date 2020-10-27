
    <div class="col-md-9">
        <div id="da-slider" class="da-slider">
            <div class="da-slide">
                <h2>Сердечное добропожаловать</h2>
                <p>Глядя в постные мор..., пардон, лица продавцов в каких-нибудь бутиках по продаже элитных тачек-телефонов-тряпок, создается впечателение, что ты им обязан. Так и кажется, что сейчас это создание откроет свое отверстие для приема пищи и рявкнет: "Ну а раз обязан, то давай сюда деньги и пшел вон - не машай созерцать вечное и прекрасное!"</p>
                <a href="#" class="da-link">Прочитать всё</a>
                <div class="da-img"><img src="{{ asset(config('settings.theme')) }}/img/1.png" alt="image01" /></div>
            </div>
            <div class="da-slide">
                <h2>Простое управление</h2>
                <p>Нет ничего проще, чем управлять. Сидишь себе в большом кожаном кресле смотришь в огромное окно на бесконечную даль. Смазливая секретарша старательно делает тебе ... кофе. А на все впоросы подчиненных бросаешь классическое "Не потерплю!". И все вертится само собой.</p>
                <a href="#" class="da-link">Прочитать всё</a>
                <div class="da-img"><img src="{{ asset(config('settings.theme')) }}/img/2.png" alt="image01" /></div>
            </div>
            <div class="da-slide">
                <h2>Революция</h2>
                <p>Когда нудный проиводственный процесс проедает плешь до печенок, нужно просто устроить революцию. Заказчик будет гневно требовать исполнения сроков, а в ответ получает "А у нас революция! Вообще все может полететь к чертям!". Справедливый гнев заказчика тут же сменится тупым обалдением от постановки ответа на вопрос.</p>
                <a href="#" class="da-link">Прочитать всё</a>
                <div class="da-img"><img src="{{ asset(config('settings.theme')) }}/img/3.png" alt="image01" /></div>
            </div>
            <div class="da-slide">
                <h2>Контроль качества</h2>
                <p>Качество можно конролировать как угодно и где угодно. Особенно хорош контроль качества на входе, ибо отсекает тонны г... , пардон, некачественного сырья для вашего замечательного продукта. Ну и на выходе надо качество контролировать - интерсно знать, на что будут жаловаться потребители.</p>
                <a href="#" class="da-link">Прочитать всё</a>
                <div class="da-img"><img src="{{ asset(config('settings.theme')) }}/img/4.png" alt="image01" /></div>
            </div>
            <nav class="da-arrows">
                <span class="da-arrows-prev"></span>
                <span class="da-arrows-next"></span>
            </nav>
        </div>
    </div>
    <div class="col-md-3">
        <div class="block_widget faq">
                <div class="col-md-12">
                    <div class="block_obj_comfort_title">Часто задаваемые вопросы</div>
                    <div class="block_faq">
                        @if(isset($faq))
                            @foreach($faq as $post)
                                <a class="site_a" href="{{route('site.post',['post'=>$post->alias])}}">{{$post->title}}</a>
                            @endforeach
                        @endif
                    </div>
                </div>

        </div>
    </div>
    <div class="col-md-12">
        @foreach($inwork as $object)
            <div class="work-block">
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
                            <span class="text_offer">{{ $object->getViewAddress() }}</span>
                            <span class="text_offer">{{ $object->getViewPrice() }} р.</span>
                            {{--<span class="desc_offer">{{ mb_strimwidth($object->desc, 0, 100, "...") }}</span>--}}
                </a>
            </div>
        @endforeach
    </div>
    <div class="col-md-12">
        @if(isset($posts))
            @foreach($posts as $post)
                <div class="grid">
                    <a href="{{route('site.post',['post'=>$post->alias])}}">
                        <div class="col-md-3">
                            <figure class="effect-steve">
                                <img class="img-responsive" src="{{ asset(config('settings.theme')) }}/uploads/post/{{$post->image}}" alt="img">
                                <figcaption>
                                    <h2>{{$post->title}}</h2>
                                    <p>{{$post->desc}}</p>
                                </figcaption>
                            </figure>
                        </div>
                    </a>
                </div>
            @endforeach
        @endif
    </div>
    <div class="col-md-12">
        <div class="title_offer">Наши партнеры:</div>
    </div>
    <div class="col-md-12">
        <div class="group_main">
            <div class="col-md-2">
                <a href="http://www.sberbank.ru/ru/person" target="_blank">
                    <div class="img_bank"><img src="{{ asset(config('settings.theme')) }}/img/sber.jpg" class="img-responsive img-rounded"></div>
                    <span class="text_bank">Сбербанк</span>
                    <span class="desc_bank">Крупнейший и старейший российский универсальный коммерческий банк, контролируется Центральным банком Российской Федерации, которому принадлежит более 52% акций.</span>
                </a>
            </div>
            <div class="col-md-2">
                <a href="http://www.vtb.ru/" target="_blank">
                    <div class="img_bank"><img src="{{ asset(config('settings.theme')) }}/img/vtb.jpg" class="img-responsive img-rounded"></div>
                    <span class="text_bank">ВТБ 24</span>
                    <span class="desc_bank">Российский коммерческий банк c государственным участием. Второй по величине активов банк страны и первый по размеру уставного капитала.</span>
                </a>
            </div>
            <div class="col-md-2">
                <a href="https://alfabank.ru/" target="_blank">
                    <div class="img_bank"><img src="{{ asset(config('settings.theme')) }}/img/alfa.jpg" class="img-responsive img-rounded"></div>
                    <span class="text_bank">Альфа Банк</span>
                    <span class="desc_bank">Крупнейший российский частный коммерческий банк. По данным рейтингов РБК и Forbes на конец 2010 года — седьмой в России банк по объёму активов.</span>
                </a>
            </div>
            <div class="col-md-2">
                <a href="" target="_blank">
                    <div class="img_bank"><img src="{{ asset(config('settings.theme')) }}/img/home.jpg" class="img-responsive img-rounded"></div>
                    <span class="text_bank">Homecredit</span>
                    <span class="desc_bank">Один из крупнейших розничных финансовых институтов на российском рынке, «дочка» чешской Home Credit Group* бизнесмена Петра Келлнера (входит в состав международной PPF Group).</span>
                </a>
            </div>
            <div class="col-md-2">
                <a href="" target="_blank">
                    <div class="img_bank"><img src="{{ asset(config('settings.theme')) }}/img/promsvyz.jpg" class="img-responsive img-rounded"></div>
                    <span class="text_bank">Промсвязьбанк</span>
                    <span class="desc_bank">Российский частный банк. Полное наименование — Публичное акционерное общество «Промсвязьбанк».</span>
                </a>
            </div>
            <div class="col-md-2">
                <a href="" target="_blank">
                    <div class="img_bank"><img src="{{ asset(config('settings.theme')) }}/img/ranf.jpg" class="img-responsive img-rounded"></div>
                    <span class="text_bank">Raiffeisen</span>
                    <span class="desc_bank">Одна из крупнейших австрийских банковских групп, кооперативный банк. Штаб-квартира находится в Вене.</span>
                </a>
            </div>
        </div>
    </div>
