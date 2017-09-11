@if(Session::has('success'))
    {{--<div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span><em> {!! session('success') !!}</em></div>--}}
    
    <section class="modal-accept">
        <div class="ma-box">
            <p>{{session('success')}}</p>
            <img src="./img/fitme-logo.png" alt="">
            {{--Первый шаг сделан!<br/>Ожидайте SMS о старте продаж--}}
        </div>
    </section>
@endif

@if(Session::has('errors'))
    {{--
    <div class="modal-alert-back"></div>
    <div class="modal-alert-wrap">
        <div class="modal-alert">
            <div class="modal-text">

                
            </div>
        </div>
    </div>--}}
    
    <section class="modal-accept">
        <div class="ma-box">
            @if (count($errors) > 0)

                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
            @endif
        </div>
    </section>
@endif
