<table id="calls" class="display" style="width:100%">
    <thead>
    <tr>
        <th>Номер телефона</th>
        <th>Статус</th>
        <th>Дата</th>
        <th>Звонок</th>
    </tr>
    </thead>
    <tbody>
    @foreach($calls as $call)
    <tr>
        <td>+7 {{$call->number}}</td>
        <td>{{$call->status ? "Входящий" : "Исходящий"}}</td>
        <td>{{$call->exec_at->format('Y-m-d H-i')}}</td>
        <td width="60%">
            <audio style="width: 100%" controls preload="none">
                <source src="{{route('call.get',[ 'data' => $call->exec_at->format('Y-m-d'),'url'=>$call->url])}}" type="audio/mpeg">
            </audio>
        </td>
    </tr>
    @endforeach
    </tbody>
</table>