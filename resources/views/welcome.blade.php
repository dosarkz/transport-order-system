@extends('layouts.app')

@section('content')
        <div class="row">

            <section class="content-header login">
            </section>

            <!-- Main content -->
            <section class="content login">
                <div class="row">

                    <form class="form-horizontal col s12" role="form" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="input-field col offset-l4 l4 s10 offset-s1">
                                <i class="material-icons prefix">phone</i>

                                <input id="phone" type="tel" class="form-control"  placeholder="7011234567" name="phone" value="{{ old('phone') }}" required autofocus>

                                <label for="phoneInputLoginForm" class="active">Номер телефона</label>
                                @if ($errors->has('phone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col offset-l4 l4 s10 offset-s1">
                                <i class="material-icons prefix">lock</i>
                                <input id="password" type="password" class="form-control"  name="password" value="{{ old('password') }}" required autofocus>

                                <label for="passwordInputLoginForm" class="">Пароль</label>
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field login-btn-field col offset-l4 l4 s10 offset-s1">
                                <button class="login-btn btn waves-effect waves-light col s12" type="submit" name="action">
                                    Войти <i class="material-icons right">send</i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </section>


        </div>
@endsection


@section('js-append')
    <script src="/plugins/input-mask/jquery.maskedinput.min.js"></script>
    <script>
        $(document).ready(function(){
            $("#phone").mask("+7(999)999-99-99");
        });

    </script>
@endsection