@extends('layouts.app')

@section('content')
        <div class="row">
            <!-- Content Header (Page header) -->
            <section class="content-header login">
            </section>

            <!-- Main content -->
            <section class="content login">
                <div class="row">


                    <form class="form-horizontal col s12" role="form" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="row">
                            <div id="sendCodeDiv">
                                <div class="input-field col offset-l4 l4 s10 offset-s1">
                                    <i class="material-icons prefix">phone</i>
                                    <input name="phone_number" id="phoneInputRegisterForm" type="tel" required  value="{{ old('phone_number') }}">
                                    <label for="phoneInputLoginForm" class="active">Номер телефона</label>

                                    @if ($errors->has('phone_number'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('phone_number') }}</strong>
                                    </span>
                                    @endif

                                </div>
                                <div class="input-field login-btn-field col offset-l4 l4 s10 offset-s1">
                                    <button id="sendSMSregisterBtn" class="login-btn btn waves-effect waves-light col s12" type="submit">
                                        Отправить смс <i class="material-icons right">send</i>
                                    </button>
                                </div>
                            </div>
                            <div id="checkCodeDiv" style="display: none;">
                                <div class="input-field col offset-l4 l4 s10 offset-s1">
                                    <i class="material-icons prefix">phone</i>
                                    <input id="smsCodeInput" type="number" class="validate">
                                    <label for="phoneInputLoginForm">Код из смс</label>
                                </div>
                                <div class="input-field login-btn-field col offset-l4 l4 s10 offset-s1">
                                    <button id="checkCodeBtnRegister" class="login-btn btn waves-effect waves-light col s12" type="submit" name="action">
                                        Проверить код <i class="material-icons right">send</i>
                                    </button>
                                </div>
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
        $("#phoneInputRegisterForm").mask("+7(999)999-99-99");
    });

</script>
@endsection