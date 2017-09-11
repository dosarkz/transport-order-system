<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/favicon.ico?" type="image/x-icon">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Unipark  - система онлайн заказов ЮниПарк</title>

    <!-- Styles -->
    {{--<link href="{{ asset('css/app.css') }}" rel="stylesheet">--}}
    <link href="{{ asset('/adminlte/css/adminlte.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="/css/main.css" >
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="/plugins/select2/select2.css">

    {{--<link rel="stylesheet" href="/dist/css/skins/_all-skins.min.css">--}}

    @yield('css')
    @yield('js')

</head>

<body class="hold-transition @if(!auth()->guest()){{auth()->user()->isDriver() ? "skin-blue" : "skin-yellow"}}@else skin-yellow @endif sidebar-mini">
<div class="wrapper">

    <header class="main-header">

        <!-- Logo -->
        <a href="/" class="logo">
            <span class="logo-mini"><b>UP</b></span>
            <span class="logo-lg"><b>Uni</b>Park</span>
        </a>

        <nav class="navbar navbar-static-top" style="background-color: #f39c12">
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>


            @if(!auth()->guest())

            <div class="input-field col-xs-3">

                {{Form::open([ 'method' => 'GET'])}}

                    @if(request()->has('service_id'))
                        {{Form::hidden('service_id', request()->input('service_id'))}}
                    @endif

                    @if(request()->has('category_id'))
                        {{Form::hidden('category_id', request()->input('category_id'))}}
                    @endif

                @php  $city = auth()->user()->city_id ? auth()->user()->city_id : 10; @endphp

                   {{Form::select('city_id', \App\Models\City::orderBy('name_ru','asc')->pluck('name_ru','id'), $city,['id' => 'userCityChooser',
                   'onChange' => 'this.form.submit()',
                    'placeholder' => 'Выберите город'])}}
                {{Form::close() }}

            </div>


                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        @if(auth()->user()->become_driver == true && auth()->user()->user_role)
                            <li>
                                <div class="switch">
                                    <label>

                                        <span class="driver-text">{{auth()->user()->user_role->role->title}}</span>

                                        <input type="checkbox" id="client-driver-switch"
                                               data-role_alias="{{auth()->user()->user_role->role->alias == 'driver' ?
                                               'client' : 'driver'}}"
                                               name="role_switch">
                                        <span class="lever"></span>
                                    </label>
                                </div>
                            </li>
                        @endif

                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                @if(auth()->user()->_image_id)
                                    <img src="https://res.cloudinary.com/dzrywvuzd/image/upload/h_48/{{auth()->user()->_image_id}}"
                                         class="user-image" alt="User Image">
                                @else
                                    <img src="/img/icon_160.png" class="user-image" alt="User Image">
                                @endif

                                <span>({{auth()->user()->fullName}})</span>
                            </a>
                            <ul class="dropdown-menu">

                                <div class="row">
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <a href="/profile" class="btn btn-default btn-flat">Профиль</a>
                                        </div>
                                        <div class="pull-right">
                                            <a href="{{ route('logout') }}"
                                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" class="btn btn-default btn-flat" >
                                                Выйти
                                            </a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                {{ csrf_field() }}
                                            </form>
                                        </div>
                                    </li>
                                </div>


                            </ul>
                        </li>
                    </ul>
                </div>
            @endif
        </nav>
    </header>

    <aside class="main-sidebar">

        <section class="sidebar">

            <div class="user-panel">
                <div class="pull-left image">

                    <img src="/img/icon_160.png" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p>UniPark</p>
                </div>
            </div>
            @if(!auth()->guest())
                {!! auth()->user()->menu() !!}
            @else
                <ul class="sidebar-menu">
                    <li class="active">
                        <a href="/login"><i class="fa fa-sign-in"></i><span>Войти</span></a>
                    </li>
                    <li>
                        <a href="/register"><i class="fa fa-user-plus"></i><span>Регистрация</span></a>
                    </li>

                </ul>
            @endif
        </section>
        <!-- /.sidebar -->
    </aside>


    <div class="content-wrapper">
        @if(Session::has('success'))
            <div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span><em> {!! session('success') !!}</em></div>
        @endif


        @if(Session::has('error'))
            <div class="alert alert-info"><span class="glyphicon glyphicon-warning-sign"></span><em> {!! session('error') !!}</em></div>
        @endif

        <div class="col-md-12">
            @if(isset($errors))
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{!! $error !!}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

            @endif
        </div>

        @yield('content')
    </div>

    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>версия</b> 1.0
            <a href="/privacy">правила пользования</a>
        </div>
        <strong>© 2017 Unipark</strong> Все права защищены

    </footer>


</div>
<!-- ./wrapper -->

<!-- Bootstrap 3.3.6 -->
<script src="/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="/bootstrap/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="/dist/js/app.min.js"></script>
<script src="/dist/js/demo.js"></script>
<script src="/plugins/select2/select2.js"></script>
<script type="text/javascript">
    $('#userCityChooser').select2();

    $('#client-driver-switch').click(function(){
        var role = this.dataset.role_alias,
        csrf_token = $('input[name="_token"]').val();

        $.ajax({
            type: "GET",
            url: '/ajax/change-role',
            data: {role: role, _token: csrf_token},
            success: function(data) {
                data.success == true ? window.location.reload() : false;
            },
            error: function(jqXHR,code, exception) {

            }
        })
    });


</script>
@yield('js-append')
</body>
</html>
