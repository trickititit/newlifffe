<div class="box-typical box-typical-padding">
    <h1>Статьи</h1>
    @if (isset($posts))
        @foreach($posts as $post)
            <div class="round-a-normal col-md-12">
                <div class="round-title col-md-8">{{$post->title}}</div>
                <div class="round-date col-md-4">Добавлено: {{$post->created_at}}</div>
                <div class="round-content col-md-12">{{$post->desc}}</div>
                <div class="col-md-12 block-a">
                    <a href="{{route('post.edit',['post'=>$post->alias])}}">
                        <button class="btn btn-default" style="float: right">Редактировать</button>
                    </a>
                    {!! Form::open(["url" => route('post.destroy', ["post" => $post->alias]), 'method' => "POST", "id" => "postDelete"]) !!}
                    {!! Form::button('Удалить', ['class' => 'btn btn-danger','type'=>'submit', 'style' => 'float:right; margin-right: 10px;']) !!}
                    {!! Form::hidden('_method', "DELETE") !!}
                    {!! Form::close() !!}
                </div>
            </div>
        @endforeach
    @endif
</div>
