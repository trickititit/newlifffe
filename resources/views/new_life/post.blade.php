    <div class="col-md-12">
        <h1 class="post-title">{{$post->title}}</h1>
        <div class="post">
            {!! $post->text !!}
        </div>
    </div>
<br />
<div class="col-md-12"><span class="post-date">{{$post->created_at}}</span></div>
