<div class="box-typical box-typical-padding">
    @if (isset($post))
        <h1>{{ $post->title }}</h1>
    @else
        <h1>Создание новой статьи</h1>
    @endif
    {!! Form::open(["url" => (isset($post->id)) ? route('post.update',['post'=>$post->alias]) : route('post.store'), 'method' => "POST", "id" => "postCreate", 'files' => 'true']) !!}
    <div class="col-md-12">
        <div class="form-group">
            <label for="title">Тема</label>
            {!! Form::text('title', isset($post->title)? $post->title : old("title"), ['id'=>'title', "class" => "form-control", "required" => ""]) !!}
        </div>
        <div class="form-group">
            <label for="text">Текст</label>
            {!! Form::textarea('text', isset($post->text)? $post->text : old("text"), ['id'=>'text', "class" => "form-control", "required" => ""]) !!}
        </div>
        <div class="form-group">
            <label for="desc">Краткое описание</label>
            {!! Form::textarea('desc', isset($post->desc)? $post->desc : old("desc"), ['id'=>'desc', "class" => "form-control", "required" => ""]) !!}
        </div>
        <div class="form-group">
            <label for="section">Раздел</label>
            {!! Form::select('section', $inputs["sections"],  isset($post->section_id) ? $post->section_id : old("section"), ["class" => "form-control"]) !!}
        </div>
        <div class="form-group">
            <div class="checkbox-bird">
                {!! Form::checkbox('on_main', '1', isset($post) ? (($post->on_main == 1) ? true : false) : false, ['id'=>'on_main']) !!}
                <label for="on_main">На главную</label>
            </div>
        </div>
        @if(isset($post->image))
            <div class="form-group">
                <label>
                    <span class="label">Изображения материала:</span>
                </label>
                <br>
                {{ Html::image(asset(config('settings.theme')).'/uploads/post/'.$post->image,'',['style'=>'width:400px']) }}
                {!! Form::hidden('old_image',$post->image) !!}
            </div>
        @endif
        <div class="form-group" id="on_main_image" {{ isset($post) ? (($post->on_main == 1) ? "" : "style=display:none;") : "style=display:none;" }}>
            <label for="image">Изображение</label>
            {!! Form::file('image', ['class' => 'filestyle','data-buttonText'=>'Выберите изображение','data-buttonName'=>"btn-primary",'data-placeholder'=>"Файла нет"]) !!}
        </div>
        @if (isset($post))
            <input type="hidden" name="_method" value="PUT">
            {!! Form::button('Сохранить', ['class' => 'btn btn-success','type'=>'submit']) !!}
        @else
            {!! Form::button('Добавить', ['class' => 'btn btn-success','type'=>'submit']) !!}
        @endif
    </div>
    {!! Form::close() !!}
</div>

