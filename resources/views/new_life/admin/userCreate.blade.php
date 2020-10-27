<div class="box-typical box-typical-padding">
    @if (isset($user))
        <h1>Профиль {{ $user->name }}</h1>
    @else
        <h1>Создание нового пользователя</h1>
    @endif
    {!! Form::open(["url" => (isset($user->id)) ? route('user.update',['user'=>$user->id]) : route('user.store'), 'method' => "POST", "id" => "userCreate", "files" => "true"]) !!}
    <div class="col-md-6">
    <div class="form-group">
        <label for="login">Логин</label>
    {!! Form::text('login', isset($user->login)? $user->login : old("login"), ['id'=>'login', "class" => "form-control", "required" => ""]) !!}
    </div>
    <div class="form-group">
        <label for="name">Имя</label>
    {!! Form::text('name', isset($user->name)? $user->name : old("name"), ['id'=>'name', "class" => "form-control", "required" => ""]) !!}
    </div>
    <div class="form-group">
        <label for="password">Пароль</label>
    {!! Form::password('password', ['id'=>'password', "class" => "form-control"]) !!}
        <small class="form-text text-muted">Для смены пароля заполните поле</small>
    </div>
    <div class="form-group">
        <label for="password_confirmation">Повтор пароля</label>
        {!! Form::password('password_confirmation', ['id'=>'password_confirmation', "class" => "form-control"]) !!}
        <small class="form-text text-muted">Для смены пароля заполните поле</small>
    </div>
    <div class="form-group">
        <label for="email">Email</label>
    {!! Form::email('email', isset($user->email)? $user->email : old("email"), ['id'=>'email', "class" => "form-control", "required" => ""]) !!}
    </div>
    <div class="form-group">
        <label for="telefon">Телефон</label>
    {!! Form::text('telefon', isset($user->telefon)? $user->telefon : old("telefon"), ['id'=>'telefon', "class" => "form-control", "required" => ""]) !!}
    </div>
     {{--@FIXME: Переделать!!!    --}}
    @if(isset($user))
        @if(Auth::user()->isAdmin())
            <div class="form-group">
                <label for="role">Роль</label>
                {!! Form::select('role', $inputs["roles"], isset($user->role) ? $user->role->id  : old('role'), ["class" => "form-control", "id" => "role"]) !!}
            </div>
        @else
                {!! Form::select('role', $inputs["roles"], isset($user->role) ? $user->role->id  : old('role'), ["class" => "form-control hidden", "id" => "role"]) !!}
        @endif
    @else
        <div class="form-group">
            <label for="role">Роль</label>
            {!! Form::select('role', $inputs["roles"], isset($user->role) ? $user->role->id  : old('role'), ["class" => "form-control", "id" => "role"]) !!}
        </div>
    @endif
    @if(Auth::user()->isAdmin())
        @if(isset($user))
            <div class="form-group">
                <label for="role">Права</label>
                @foreach($polices as $police)
                    <div class="checkbox-bird">
                        @set($check, 0)
                        @foreach($user->polices as $u_police)
                            @if($u_police->id == $police->id)
                                @set($check, 1)
                                @break
                            @else
                                @set($check, 0)
                            @endif
                        @endforeach
                        {!! Form::checkbox('polices[]', $police->id, ($check == 1)? true : false, ["id" => "police".$police->id]) !!}
                        <label for="police{{ $police->id }}">{{$police->name}}</label>
                    </div>
                @endforeach
            </div>
        @else
            <div class="form-group">
                <label for="role">Права</label>
                @foreach($polices as $police)
                    <div class="checkbox-bird">
                        {!! Form::checkbox('polices[]', $police->id, false, ["id" => "police".$police->id]) !!}
                        <label for="police{{ $police->id }}">{{$police->name}}</label>
                    </div>
                @endforeach
            </div>
        @endif
    @endif
        <div class="form-group">
            <label for="role">Аватар</label>
            @if(isset($user->image))
                <img class="profile-img img-circle" src="{{ asset(config('settings.theme')) }}/uploads/avatar/avatar-{{$user->id}}-256{{$user->image}}">
                <p>Чтобы заменить изображение загрузите новое</p>
            @endif    
                {!! Form::file('image', ['class' => 'filestyle','data-buttonText'=>'Выберите изображение','data-buttonName'=>"btn-primary",'data-placeholder'=>"Файла нет"]) !!}
        </div>
    @if(isset($user))
        <input type="hidden" name="_method" value="PUT">
    @endif
    @if (isset($user))
            {!! Form::button('Сохранить', ['class' => 'btn btn-success','type'=>'submit']) !!}
    @else
            {!! Form::button('Добавить', ['class' => 'btn btn-success','type'=>'submit']) !!}
    @endif
    </div>
    {!! Form::close() !!}
</div>