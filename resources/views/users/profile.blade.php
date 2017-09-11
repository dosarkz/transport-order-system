@extends('layouts.app')

@section('content')
        <div class="row">


            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
        @endif


        {{Form::open(['url' => 'user/update', 'method' => 'POST', 'files' => true])}}
        <!-- Profile Image -->
            <div class="col s12">
                <div class="row">
                    <div class="col l3 s12">
                        <div class="center-align">
                            @if(auth()->user()->_image_id)
                               <img class="profile-user-img img-responsive img-circle" style="cursor: pointer; font-size: 50px" src="https://res.cloudinary.com/dzrywvuzd/image/upload/h_48/{{auth()->user()->_image_id}}" alt="User profile picture">
                                <a class="btn btn-warning" href="/user/remove-avatar">Удалить фото</a>
                            @else
                                <img src="/img/unipark.png" alt="" class="profile-user-img img-responsive img-circle">
                            @endif
                            <input type="file" name="avatar" id="avatar-file" class="hidden">
                        </div>
                        <div>
                            <h5 class="center-align"><i class="material-icons">stay_current_portrait</i> +7{{auth()->user()->phone}}</h5>

                        </div>
                    </div>

                    <div class="col l9 s12">
                        <div class="input-field col l6 s12">
                            <i class="material-icons prefix">account_circle</i>
                            {{Form::text('first_name', auth()->user()->first_name)}}
                            <label for="first_name" class="active">Имя</label>
                        </div>
                        <div class="input-field col l6 s12">
                            {{Form::text('last_name', auth()->user()->last_name)}}
                            <label for="last_name" class="active">Фамилия</label>
                        </div>
                        <div class="input-field col l4 s12">
                            <i class="material-icons prefix">email</i>
                            {{Form::text('email', auth()->user()->email)}}
                            <label for="email_addr" class="active">Email</label>
                        </div>
                        <div class="input-field col l4 s12">
                            {{Form::text('birthday', auth()->user()->birthday, ['id' => 'bdate', 'class' => 'form-control'])}}
                            <label for="bdate" class="active">Дата рождения</label>
                        </div>

                        <div class="input-field col l4 s12">
                            {{Form::select('gender',[1 => 'Мужской', 2 => 'Женский'], auth()->user()->gender,['id' => 'profilePol', 'placeholder' => 'Выберите пол' ])}}
                            <label>Пол</label>
                        </div>

                        <div class="input-field col l6 s12 hidden">
                            {{Form::text('company', auth()->user()->company, [ 'class' => 'form-control'])}}
                            <label for="company_name">Компания</label>
                        </div>

                        <div class="col l6 s12">
                            <label for="profileCityId">Город</label>
                            {{Form::select('city_id', \App\Models\City::orderBy('name_ru','asc')->pluck('name_ru','id'), auth()->user()->city_id,
                            ['id' => 'profileCityId', 'class' => 'form-control', 'placeholder' => 'Выберите город'])}}
                        </div>

                        <div class="col l6 s12 form-group">
                            <!-- Switch -->
                            Стать Водителем
                            <div class="switch">
                                <label>
                                    Нет

                                    @if(auth()->user()->become_driver)
                                        {{Form::checkbox('become_driver',auth()->user()->become_driver, auth()->user()->become_driver)}}
                                    @else
                                        {{Form::checkbox('become_driver')}}
                                    @endif

                                    <span class="lever"></span>
                                    Да
                                </label>
                            </div>
                        </div>

                        @if(auth()->user()->isDriver())

                            <div class="col s12">
                                <div class="input-field col s12">
                                    <textarea id="driverAboutText" name="driver_about" class="materialize-textarea">{{auth()->user()->driver_about}}</textarea>
                                    <label for="driverAboutText">О себе</label>
                                </div>
                            </div>
                            <div class="col s12">

                                @foreach($driverServices as $driverService)
                                    <div class="col m4 s12">
                                        <!-- Switch -->
                                        <div class="switch">
                                            <label>
                                                Off
                                                <input type="checkbox" class="profileServices" data-id="{{$driverService->id}}">
                                                <span class="lever"></span>
                                                On
                                            </label>
                                        </div>
                                        {{$driverService->name}}
                                    </div>

                                @endforeach

                            </div>
                            <div class="col s12">
                                @foreach($driverLicenses as $driverLicense)

                                    @php
                                        $userDriverLicense = \App\Models\UserDriverLicense::where('driver_license_id', $driverLicense->id)
                                         ->where('user_id', auth()->user()->id)
                                         ->first();

                                         if($userDriverLicense)
                                         {
                                          $checkStatusLicense = 'checked';
                                         }else{
                                          $checkStatusLicense = null;
                                         }

                                    @endphp
                                    <div class="col s1">
                                        <input type="checkbox" class="filled-in licenses" name="licenses[]" value="{{$driverLicense->id}}" {{$checkStatusLicense}} id="license{{$driverLicense->id}}"  />
                                        <label for="license{{$driverLicense->id}}">{{$driverLicense->name}}</label>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <div class="input-field col s12">
                            <div class="col l6 s12">
                                <button type="submit" class="waves-effect waves-light btn" id="save_profile"><i class="material-icons left">save</i>Сохранить</button>
                            </div>
                            <div class="col l6 s12">
                                <a class="waves-effect waves-light btn modal-trigger" href="#changePasswordModal"><i class="material-icons left">vpn_key</i>Изменить пароль</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        {{Form::close() }}


        <!-- /.box -->

            <!-- Modal Trigger -->


            <!-- Modal Structure -->
            <div id="changePasswordModal" class="modal bottom-sheet">
                <div class="modal-content">
                    <h4>Смена пароля</h4>
                    <form action="/user/change-password" method="POST">
                        {{csrf_field()}}
                        <div class="row">
                            <div class="input-field col l3 s12 offset-l2">
                                <input id="password" type="password" name="password" required class="validate">
                                <label for="password">Новый пароль</label>
                            </div>
                            <div class="input-field col l3 s12">
                                <input id="password2" type="password" name="password_confirmation" required class="validate">
                                <label for="password2">Еще раз</label>
                            </div>
                            <div class="input-field col l3 s12">
                                <button class="waves-effect waves-light btn" type="submit" id="change_pwd_btn"><i class="material-icons left">done</i>Изменить</button>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col l8 s12 offset-l2">
                            <blockquote>Внимание! После успешней смены пароля Вам заново надо будет авторизоваться с новым паролем </blockquote>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">

                </div>
            </div>


        </div>
@endsection

@section('css')
    <link rel="stylesheet" href="/plugins/datepicker/datepicker3.css">
    {{--<link rel="stylesheet"href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.0/css/materialize.min.css">--}}
@endsection

@section('js-append')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.2/js/materialize.min.js"></script>
    <script src="/plugins/datepicker/bootstrap-datepicker.js"></script>
    <script>
        $(document).ready(function() {
            $('#bdate').datepicker({
                format: "dd.mm.yyyy",
                language: "ru",
                startView: 1,
                clearBtn: false,
                autoclose: true,
                defaultViewDate: { year: 1995, month: 01, day: 01 }
            });

            $('#profilePol').material_select();

            $('.modal-trigger').leanModal({
                ready: function(){

                },
                complete:function(){
                }
            });

            $(".profile-user-img").click(function(e){
                e.preventDefault();
                $('#avatar-file').trigger('click');
            });


        });
    </script>
@endsection

