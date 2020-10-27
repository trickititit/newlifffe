@if($items)
    @foreach($items as $item)
        <li class="nav-item">
            <a class="nav-link {{ $type == $item->type ? "active" : '' }}" href="{{$item->url()}}">{{$item->title}}<span class="badge {{ ($item->type == 'completed' && $item->count > 0) ? 'badge-danger' : 'badge-default' }} margin-left">{{$item->count}}</span></a>
        </li>
    @endforeach
@endif
