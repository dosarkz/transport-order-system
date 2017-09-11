@extends('layouts.app')

@section('content')
        <div class="row">
            <!-- Content Header (Page header) -->
            <section class="content-header login">
            </section>

            <!-- Main content -->
            <section class="content login">
                <div class="row">


                    <form class="form-horizontal col s12" role="form" method="POST" action="/register/confirm-sms">
                        {{ csrf_field() }}

                        <div class="row">

                            <div id="checkCodeDiv">
                                <div class="input-field col offset-l4 l4 s10 offset-s1">
                                    <i class="material-icons prefix">phone</i>
                                    <input name="code" id="smsCodeInput" type="number" class="validate">
                                    <label for="phoneInputLoginForm">Код из смс</label>

                                    <input type="hidden" name="phone" value="{{request()->input('phone')}}">

                                    @if ($errors->has('code'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('code') }}</strong>
                                    </span>
                                    @endif

                                </div>
                                <div class="input-field login-btn-field col offset-l4 l4 s10 offset-s1">
                                    <button id="checkCodeBtnRegister" class="login-btn btn waves-effect waves-light col s12" type="submit">
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