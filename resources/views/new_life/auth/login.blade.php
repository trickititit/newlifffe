@extends(config('settings.theme').'.layouts.auth')

@section('content')
    <div class="bg-gradient"></div>
    <div class="page-center">
        <div class="page-center-in">
            <div class="container-fluid">
                {!! Form::open(["url" => route('login'), "class" => "sign-box", 'method' => "POST"]) !!}
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
                    <header class="sign-title">Вход на сайт</header>
                    <div class="form-group {{ $errors->has('login') ? 'form-group-error' : '' }}">
                        {!! Form::text('login', old("login"), ["id" => "login" ,"class" => "form-control", "placeholder" => "Логин", "required" => ""]) !!}
                    </div>
                    <div class="form-group {{ $errors->has('password') ? 'form-group-error' : '' }}">
                        {!! Form::password('password', ["id" => "password" ,"class" => "form-control", "placeholder" => "Пароль", "required" => ""]) !!}
                    </div>
                    <div class="form-group">
                        <div class="checkbox float-left">
                            <input type="checkbox" id="signed-in" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label for="signed-in">Запомнить меня</label>
                        </div>
                        <div class="float-right reset">
                            <a href="{{ route('password.request') }}">Забыли пароль?</a>
                        </div>
                    </div>
                    {!! Form::submit("Войти", ["class" => "btn btn-rounded"]) !!}
                    <p class="sign-note">Впервые на сайте? <a href="{{ route('register') }}">Зарегистрироваться</a></p>

                {!! Form::close() !!}
            </div>
        </div>
    </div><!--.page-center-->

@endsection
