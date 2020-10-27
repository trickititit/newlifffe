<div class="box-typical box-typical-padding">
<h1>Пользователи</h1>
<div class="table-responsive">
<table class="table table-hover">
    <thead>
    <tr>
        <th>Имя</th>
        <th>Роль</th>
        <th>Контакты</th>
        <th>Почта</th>
        <th>Завершенные</th>
        <th>Действие</th>
    </tr>
    </thead>
    <tbody>
    @if (isset($users))
        @foreach($users as $user)
            <tr>
                <td>{{$user->name}}</td>
                <td>{{$user->role->name}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->completedObjects->count()}}</td>
                <td class="users-actions" width="300"><a href="{{route("user.edit", ["user" => $user->id])}}" class="btn btn-inline btn-success-outline">Редактировать</a>
                    {!! Form::open(["url" => route('user.destroy', ["user" => $user->id]), 'method' => "POST", "id" => "userDelete", "onSubmit" => "return confirm('Вы уверены?');"]) !!}
                    {!! Form::button('Удалить', ['class' => 'btn btn-inline btn-danger-outline','type'=>'submit']) !!}
                    {!! Form::hidden('_method', "DELETE") !!}
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
    @endif
    </tbody>
</table>
</div>
</div>