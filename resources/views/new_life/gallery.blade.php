@if ($images->isNotEmpty())
    <div class="col-md-12 col-sm-12 gallery margin-top-gallery">
        <ul id="imageGallery">
            @foreach($images as $image)
            <li data-thumb="{{ asset(config('settings.theme')) }}\uploads\images\{{$image->object_id}}\thumb-{{ $image->new_name }}"  data-src="{{ asset(config('settings.theme')) }}\uploads\images\{{$image->object_id}}\{{$image->new_name}}" >
                <img class="img-fluid" style="height: 550px !important;"  src="{{ asset(config('settings.theme')) }}\uploads\images\{{$image->object_id}}\thumb-{{$image->new_name}}">
            </li>
            @endforeach
        </ul>
    </div>
@endif
