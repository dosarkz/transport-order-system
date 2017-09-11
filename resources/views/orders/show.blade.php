@extends('layouts.app')

@section('content')
        <div class="row">

            <div class="row">
                <div class="col s12">
                    <div class="card-panel">
                        <h5 class="text-center">
                            Заказ #{{$model->id}}
                            ({{$model->status ? $model->status->status_text : null}})
                        </h5>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s12">
                    {{--<div class="card-panel" style="height: 400px; position: relative; overflow: hidden;" id="viewSingleMap"></div>--}}
                    @include('orders.form')
                </div>
            </div>


            <!-- Main content -->
            <section class="content">

                <div class="row">



                    <div class="col-xs-12">

                        <!-- esli u nas est voditel: -->
                        <h4>Ваш Поставщик</h4>
                        @if($model->transport)
                            <div class="card lighten-5">
                                <div class="card-content">
                                <span class="card-title activator grey-text text-darken-4">
                                    {{$model->transport->transportBrand->name}} {{ $model->transport->car_gos_number}}
                                    </span>
                                    <div class="row">
                                        <div class="order-left-part col s4">
                                            <div>
                                                <a href="#" class="view-auto-images" data-carid="2091" data-driverid="dY96zeX5ZNn5SNZZR">

                                                    <img src="/img/icon_160.png" class="img img-thumbnail">

                                                </a>
                                            </div>
                                        </div>

                                        <div class="order-right-part col s8">
                                            <div class="col s12 order-name-status"  data-id="{{$model->id}}">
                                                #{{$model->id}} @if($model->status)<span>{{$model->status->status_text}}</span>@endif

                                                @if($model->transport && $model->transport->driver)
                                                    <div class="col s2 driver-image-holder">
                                                        @if($model->transport->driver->_image_id)
                                                            <img src="https://res.cloudinary.com/dzrywvuzd/image/upload/h_48/{{$model->transport->driver ? $model->transport->driver->_image_id : null}}" class="img img-circle offset-s1" >
                                                        @else
                                                            <img src="/img/icon_160.png" class="img img-circle z-depth-3">
                                                        @endif

                                                    </div>
                                                    <div class="col s3">
                                                        <div>{{$model->transport->driver->fullName}} </div>
                                                    </div>
                                                    <div class="col s4">
                                                        <div>{{$model->transport->car_gos_number}} </div>

                                                    </div>
                                                @endif
                                            </div>


                                            <div class="col s9">
                                                <a href="/orders/{{$model->id}}">

                                                    <div class="col s12 top-buffer">
                                                <span class="price-date-timer">
                                                {{$model->service ? $model->service->name : null}}
                                                    @if($model->transport)
                                                        {{$model->transportCategory ? $model->transportCategory->name : null}}
                                                    @endif

                                                </span>
                                                        <p>

                                                            @if($model->transport)
                                                                {{$model->transport->transportCategory->name}} |  {{$model->transport->transportBrand ? $model->transport->transportBrand->name : null}} | {{$model->transport->transportModel ? $model->transport->transportModel->name : null}}
                                                            @endif
                                                        </p>
                                                    </div>

                                                    <div class="col s12">{{$model->start_point_text}} - {{$model->end_point_text}}</div>

                                                    <div class="order-description top-buffer col s12">{{$model->description}}</div>




                                                    <div class="col s5 price-date-timer">
                                                        <i class="fa fa-clock-o icon-color"></i> {{$model->date_start}}
                                                    </div>

                                                    <div class="col s3 price-date-timer">
                                                        <i class="fa fa-comment icon-color"></i> {{$model->transportRequests->count()}}
                                                    </div>
                                                    <div class="col s12 price-date-timer" style="font-size:2em;">
                                                        <span class="icon-color">&#8376;</span> {{$model->transport->car_hourly_price}}
                                                    </div>


                                                </a>
                                            </div>

                                            <div class="col s12">

                                                <div class="row">
                                                    <a href="/orders/{{$model->id}}/cancel-a-driver"  class="btn btn-primary" >Отменить водителя</a>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>  <!-- card :-->
                        @else

                            @if($model->transportRequests->count() == 0)
                                <p>Нет запросов от Поставщиков</p>
                            @endif

                            <div class="row">
                                <h4>Список запросов</h4>

                                <div class="row">

                                    @foreach($model->transportRequests as $request)
                                        <div class="card lighten-5">
                                            <div class="card-content">
                                <span class="card-title activator grey-text text-darken-4">
                                    {{$request->transport->transportBrand->name}} {{ $request->transport->car_gos_number}}
                                    </span>
                                                <div class="row">
                                                    <div class="order-left-part col s4">
                                                        <div>
                                                            <a href="#" class="view-auto-images" data-carid="2091" data-driverid="dY96zeX5ZNn5SNZZR">

                                                                <img src="/img/icon_160.png" class="img img-thumbnail">

                                                            </a>
                                                        </div>
                                                    </div>

                                                    <div class="order-right-part col s8">
                                                        <div class="col s12 order-name-status"  data-id="{{$model->id}}">
                                                            #{{$model->id}} @if($model->status)<span>{{$model->status->status_text}}</span>@endif

                                                            @if($request->transport && $request->transport->driver)
                                                                <div class="col s2 driver-image-holder">
                                                                    @if($request->transport->driver->_image_id)
                                                                        <img src="https://res.cloudinary.com/dzrywvuzd/image/upload/h_48/{{$request->transport->driver ? $request->transport->driver->_image_id : null}}" class="img img-circle offset-s1" >
                                                                    @else
                                                                        <img src="/img/icon_160.png" class="img img-circle z-depth-3">
                                                                    @endif

                                                                </div>
                                                                <div class="col s3">
                                                                    <div>{{$request->transport->driver->fullName}} </div>
                                                                </div>
                                                                <div class="col s4">
                                                                    <div>{{$request->transport->car_gos_number}} </div>

                                                                </div>
                                                            @endif
                                                        </div>


                                                        <div class="col s9 form-group">
                                                            <a href="/orders/{{$model->id}}">

                                                                <div class="col s12 top-buffer">
                                                            <span class="price-date-timer">
                                                                {{$model->service ? $model->service->name : null}}
                                                                {{$model->transportCategory ? $model->transportCategory->name : null}}
                                                            </span>
                                                                    <p>
                                                                        @if($request->transport)
                                                                            {{$request->transport->transportCategory->name}} |  {{$request->transport->transportBrand ? $request->transport->transportBrand->name : null}} | {{$request->transport->transportModel ? $request->transport->transportModel->name : null}}
                                                                        @endif
                                                                    </p>
                                                                </div>

                                                                <div class="col s12">{{$model->start_point_text}} - {{$model->end_point_text}}</div>

                                                                <div class="order-description top-buffer col s12">{{$model->description}}</div>




                                                                <div class="col s5 price-date-timer">
                                                                    <i class="fa fa-clock-o icon-color"></i> {{$model->date_start}}
                                                                </div>

                                                                <div class="col s3 price-date-timer">
                                                                    <i class="fa fa-comment icon-color"></i> {{$model->transportRequests->count()}}
                                                                </div>
                                                                <div class="col s12 price-date-timer" style="font-size:2em;">
                                                                    <span class="icon-color">&#8376;</span> {{$request->price}}
                                                                </div>


                                                            </a>
                                                        </div>


                                                            <div class="form-group">
                                                                @if($model->status_id == \App\Models\Order::STATUS_IN_PROCESSING)
                                                                    <a href="/orders/{{$model->id}}/confirm-a-driver-request/{{$request->id}}"  class="btn btn-primary" >Одобрить водителя</a>
                                                                @endif
                                                            </div>




                                                    </div>
                                                </div>
                                            </div>

                                        </div>  <!-- card :-->
                                    @endforeach

                                </div>
                            </div>

                        @endif
                    </div>



                </div>

                <!-- Modal Structure -->
                <div id="modalOrderTrash" class="modal">
                    <div class="modal-content">
                        <h4>Удаление заказа</h4>
                        <div class="row">
                            <blockquote>Ваш заказ навсегда удалиться с Системы</blockquote>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class=" modal-action modal-close waves-effect waves-red btn-flat">не надо удалять</a>
                        <a href="#" id="OrderTrashBtn" class="modal-action modal-close waves-effect waves-green btn-flat" data-id="1866" data-ordercode="1866">Да, Я согласен удалить заказ</a>
                    </div>
                </div>

                <!-- Modal Structure -->
                <div id="modalOrderClose" class="modal">
                    <div class="modal-content">
                        <h4>Завершение заказа</h4>
                        <form>
                            <div class="row">
                                <div class="row">
                                    <div class="input-field col s12">
                                        <textarea id="WriteOrderReview" placeholder="отзыв о поставщике" class="materialize-textarea"></textarea>
                                        <label for="WriteOrderReview" class="active">Оставить отзыв</label>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <a href="" class="modal-action modal-close waves-effect waves-red btn-flat">X</a>
                        <a href="#" id="OrderCloseBtn" class="modal-action modal-close waves-effect waves-green btn-flat" data-id="1866" data-ordercode="1866">Да, я согласен закрыть заказ</a>
                    </div>
                </div>
                <div class="hide"><input type="date" id="datepicker" class="datepicker"></div>

            </section>


        </div>
@endsection

@section('css')
    <link rel="stylesheet" href="/plugins/datepicker/datepicker3.css">
    {{--<link rel="stylesheet"href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.0/css/materialize.min.css">--}}
@endsection


@section('js-append')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.2/js/materialize.min.js"></script>
    <script src="/plugins/datepicker/bootstrap-datepicker.js"></script>
    <script src="/plugins/datepicker/locales/bootstrap-datepicker.ru.js"></script>
    <script>
        $(document).ready(function() {
            $("#singleOrderDate").datepicker(
                    {
                        format: "dd.mm.yyyy",
                        language: "ru",
                        autoclose: true,
                        constrainInput: false,
                        orientation: 'top',
                        //todayBtn:true,
                        todayHighlight: true,
                        toggleActive: true
                    }
            );
        });
    </script>
@endsection