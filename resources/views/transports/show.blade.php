@extends('layouts.app')


@section('content')
        <div class="row">
            <!-- Content Header (Page header) -->
            <section class="content-header text-center">
                <h1>{{$model->transportBrand ? $model->transportBrand->name : null}} - {{$model->car_gos_number}}</h1>
            </section>

            <!-- Main content -->
            <section class="content">

                <div class="col-md-12">
                    <div class="col-md-6">
                        <div class="box box-solid">
                            <!-- /.box-header -->
                            <div class="box-body z-depth-1">

                                <div id="myCarousel" class="carousel slide" data-ride="carousel">
                                    <!-- Indicators -->
                                    <ol class="carousel-indicators">
                                        @foreach($model->transportImages as $key => $image)
                                            <li data-target="#myCarousel" data-slide-to="{{$key}}" @if($key == 0)class="active" @endif></li>
                                        @endforeach

                                    </ol>

                                    <!-- Wrapper for slides -->
                                    <div class="carousel-inner">

                                        @if($model->transportImages)

                                            @if($model->transportImages->count() == 0)
                                                <div class="item active">

                                                    <img src="/img/icon_512.png" alt="slide pic" style="margin-left:5em;" width="300">
                                                </div>
                                            @endif

                                            @foreach($model->transportImages as $key => $transportImage)

                                                @if($transportImage->_public_image_id)
                                                    <div class="item {{$key == 0 ? 'active' : null}}">
                                                        <a href="https://res.cloudinary.com/dzrywvuzd/image/upload/w_800/{{$transportImage->_public_image_id}}" data-lightbox="image-{{$key}}" data-title="My caption">
                                                            <img src="https://res.cloudinary.com/dzrywvuzd/image/upload/w_800/{{$transportImage->_public_image_id}}" alt="">
                                                        </a>
                                                    </div>
                                                @else
                                                    <div class="item {{$key == 0 ? 'active' : null}}">

                                                        <a href="/{{$transportImage->image->getFullImage()}}" data-lightbox="image-{{$key}}" data-title="{{$model->transportBrand ? $model->transportBrand->name : null}} - {{$model->car_gos_number}}">
                                                            <img src="/{{$transportImage->image->getFullImage()}}" alt="">
                                                        </a>



                                                    </div>
                                                @endif
                                            @endforeach

                                        @endif


                                    </div>

                                    <!-- Left and right controls -->
                                    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                                        <span class="glyphicon glyphicon-chevron-left"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="right carousel-control" href="#myCarousel" data-slide="next">
                                        <span class="glyphicon glyphicon-chevron-right"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>

                            </div>
                            <div class="box-footer z-depth-1">
                                <div class="row">
                                    <div class="col s8">

                                        <div class="col s12">
                                            <img src="/img/icon_160.png" height="70">
                                        </div>
                                        <div class="col s12">
                                            {{$model->driver ? $model->driver->fullName : null}}
                                        </div>
                                        <div class="col s12">
                                            @if($model->driver)
                                                <i class="material-icons">stay_current_portrait</i>  +7{{$model->driver->phone}}
                                            @endif
                                        </div>

                                    </div>

                                </div>


                            </div>

                            <!-- /.box-body -->
                            <!-- /.box-body -->
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="col-md-12">
                            <div class="box box-solid">
                                <!-- /.box-header -->
                                <div class="box-body">
                                    <blockquote>
                                        Цена за час: {{$model->car_hourly_price}} тенге
                                    </blockquote>

                                    @if($model->city_id)
                                        <p><b>Город</b>: {{$model->city->name_ru}}</p>
                                    @endif

                                    <p><b>год выпуска</b>: {{$model->car_production_year_id}}</p>


                                    <blockquote>услуги</blockquote>

                                    @foreach($model->transportServices as $transportService)
                                        <p>
                                            <img src="https://res.cloudinary.com/dzrywvuzd/image/upload/w_32/{{$transportService->service->_image_id}}">
                                            <b>{{$transportService->service->name}}</b>:

                                            @php $prices = false; @endphp

                                            @foreach($transportService->servicePriceOptions as $servicePriceOptions)
                                                @php $prices[] = $servicePriceOptions->priceOption->name .' - '. $servicePriceOptions->price .' тенге'; @endphp
                                            @endforeach

                                            @if($prices)
                                                {{implode(",", $prices)}}
                                            @endif

                                        </p>
                                    @endforeach

                                </div>
                            </div>

                <div class="col s12">

                    @if(request()->has('service_id'))
                       <a data-toggle="modal"
                          data-target="#new-order-modal"
                          data-service_id="{{request()->input('service_id')}}"
                          data-status_id="{{\App\Models\Order::STATUS_IN_PROCESSING}}"
                          data-transport_id="{{$model->id}}"
                          data-price="{{$model->car_hourly_price}}"
                          data-city_id="{{$model->city ? $model->city->id :null}}"
                          class="btn btn-large col s4 offset-s1 waves-effect waves-light yellow darken-4">
                           <i class="fa fa-mouse-pointer"></i> заказать</a></span>
                    @endif

                    @if(request()->has('category_id'))
                        <a data-toggle="modal"
                           data-target="#new-order-modal"
                           data-category_id="{{request()->input('category_id')}}"
                           data-status_id="{{\App\Models\Order::STATUS_IN_PROCESSING}}"
                           data-transport_id="{{$model->id}}"
                           data-price="{{$model->car_hourly_price}}"
                           data-city_id="{{$model->city ? $model->city->id :null}}"
                           class="btn btn-large col s4 offset-s1 waves-effect waves-light yellow darken-4">
                            <i class="fa fa-mouse-pointer"></i> заказать</a>
                    @endif

                </div>
                        </div>
                    </div>


                </div>


            </section>

        </div>
    @include('modals.new_order')
@endsection


@section('css')
    <link href="/lightbox/css/lightbox.css" type="text/css" rel="stylesheet">
@endsection

@section('js-append')
    <script src="/lightbox/js/lightbox.js"></script>
    <script type="text/javascript">
        $('#new-order-modal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var service_id = button.data('service_id');
            var category_id = button.data('category_id');
            var city = button.data('city_id');
            var price = button.data('price');
            var status_id = button.data('status_id');
            var transport_id = button.data('transport_id');

            var modal = $(this);
            modal.find('div#category_id').remove();
            modal.find('#city_block').addClass('hidden');
            modal.find('select#select_city_id').val(city);
            modal.find('input#orderPrice').val(price);

            var input = document.createElement("input");
            var transport_input = document.createElement("input");
            var status_input = document.createElement('input');

            status_input.type = 'hidden';
            status_input.name = 'status_id';
            status_input.value = status_id;

            transport_input.type = 'hidden';
            transport_input.name = 'car_id';
            transport_input.value = transport_id;

            modal.find('.modal-body').append(transport_input);
            modal.find('.modal-body').append(status_input);

            if(service_id != null)
            {
                input.type = "hidden";
                input.name = 'service_id';
                input.value = service_id;
                modal.find('.modal-body').append(input);
                modal.find('form').attr('action', '/orders?type=service');
                modal.find('.modal-title').text('Новый заказ в услуге');
            }

            if(category_id != null)
            {
                input.type = "hidden";
                input.name = 'category_id';
                input.value = category_id;
                modal.find('.modal-body').append(input);
                modal.find('form').attr('action', '/orders?type=transport');
                modal.find('.modal-title').text('Новый заказ в транспорте');
            }

        });
    </script>
@endsection