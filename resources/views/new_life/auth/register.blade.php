@extends(config('settings.theme').'.layouts.auth')

@section('content')
    <div class="bg-gradient"></div>
    <div class="page-center">
        <div class="page-center-in">
            <div class="container-fluid">
                {!! Form::open(["url" => route('register'), "class" => "sign-box", 'method' => "POST"]) !!}
                <div class="sign-avatar">
                    <img src="{{ asset(config('settings.theme')) }}/img/login-logo.png" alt="">
                </div>
                @if (count($errors) > 0)
                    <div class="form-error-text-block">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <header class="sign-title">Регистрация</header>
                <div class="form-group {{ $errors->has('login') ? 'form-group-error' : '' }}">
                    {!! Form::text('login', old("login"), ["id" => "login" ,"class" => "form-control", "placeholder" => "Логин", "required" => ""]) !!}
                </div>
                <div class="form-group {{ $errors->has('password') ? 'form-group-error' : '' }}">
                    {!! Form::password('password', ["id" => "password" ,"class" => "form-control", "placeholder" => "Пароль", "required" => ""]) !!}
                </div>
                <div class="form-group">
                    {!! Form::password('password_confirmation', ["id" => "password-confirm" ,"class" => "form-control", "placeholder" => "Подтверждение пароля", "required" => ""]) !!}
                </div>
                <div class="form-group {{ $errors->has('name') ? 'form-group-error' : '' }}">
                    {!! Form::text('name', old("name"), ["id" => "name" ,"class" => "form-control", "placeholder" => "Имя", "required" => ""]) !!}
                </div>
                <div class="form-group {{ $errors->has('email') ? 'form-group-error' : '' }}">
                    {!! Form::email('email', old("email"), ["id" => "email" ,"class" => "form-control", "placeholder" => "Email", "required" => ""]) !!}
                </div>

                {!! Form::submit("Зарегистрироваться", ["class" => "btn btn-rounded btn-success sign-up"]) !!}
                <p class="sign-note">Уже есть аккаунт? <a href="{{ route('login') }}">Войти</a></p>

                {!! Form::close() !!}
            </div>
        </div>
    </div><!--.page-center-->

@endsection