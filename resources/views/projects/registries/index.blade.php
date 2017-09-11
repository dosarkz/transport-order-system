@extends('layouts.app')

@section('content')
    <div class="row">


        <section class="content-header">
            <h1>
                {{$project->name}}
                <small>управление проектом</small>
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="pull pull-right">
                    <a href="/projects/{{$project->id}}/create-order" class="btn btn-xs btn-primary" id="project-create-order">создать заказ</a>
                </div>

            </div>
            <div class="row">
                <div class="nav-tabs-custom">
                    @include('projects.nav')
                    <div class="tab-content">

                        <div id="orders" class="tab-pane active">
                            <div class="row">

                                <a class="btn btn-default form-control" role="button" data-toggle="collapse" href="#collapseExample"
                                   aria-expanded="false" aria-controls="collapseExample">
                                    <i class="material-icons">info_outline</i> Фильтр по параметрам
                                </a>
                                <form method="GET">
                                    <div class="collapse" id="collapseExample">
                                        <div class="well">
                                            <div class="row">
                                                <div class="col m12 s12">

                                                    <div class="input-field col m2 s12">
                                                        {{Form::text('date_start', $project->date_start, ['id' => 'date_start_picker', 'placeholder' => 'Дата начало'])}}
                                                    </div>

                                                    <div class="input-field col m2 s12">
                                                        {{Form::text('date_end', $project->date_end, ['id' => 'date_end_picker', 'placeholder' => 'Дата завершения'])}}
                                                    </div>

                                                    <div class=" input-field col m2 s12">
                                                        <label for="projectFilterOrderId">N заказ</label>
                                                        {{Form::number('order_id', $project->order_id, ['id' => 'order_id', 'placeholder' => 'N заказ'])}}
                                                    </div>

                                                    <div class="col m3 s12">
                                                        <label for="projectOrderClientContragentId">Заказчик</label>
                                                        {{Form::select('contractor_id', $contractorsList, $project->contractor_id, ['class' =>
                                                            'form-control', 'id'=> 'projectOrderClientContragentId', 'style'=> 'width: 100%',
                                                            'placeholder' => 'Не важно'])}}
                                                    </div>

                                                    <div class="col m3 s12">
                                                        <label for="projectOrderDriverId">Водитель</label>

                                                        {{Form::select('driver_id', $driversList, $project->driver_id, ['class' =>
                                                           'form-control', 'id'=> 'projectOrderDriverId', 'style'=> 'width: 100%',
                                                           'placeholder' => 'Не важно'])}}
                                                    </div>

                                                    <div class="col m3 s12">
                                                        <label for="projectOrderCreatedBy">Менеджер</label>

                                                        {{Form::select('manager_id', $managersList, '', ['class' =>
                                                          'form-control', 'id'=> 'projectOrderCreatedBy', 'style'=> 'width: 100%',
                                                          'placeholder' => 'Не важно'])}}
                                                    </div>

                                                </div>
                                                <div class="col m12 s12 form-group">



                                                    <div class="col m2 s12">
                                                        <label for="selectCatId">Вид авто</label>
                                                        {{Form::select('transport_category_id', $transport_categories,
                                                        $project->transport_category_id, ['class' =>
                                                           'form-control', 'id'=> 'selectCatId', 'style'=> 'width: 100%',
                                                            'placeholder' => 'Не важно'])}}
                                                    </div>

                                                    <div class="col m2 s12">
                                                        <label for="selectMarkaId">Марка авто</label>

                                                        {{Form::select('transport_brand_id', request()->has('transport_category_id') ? $project->listBrandsByCategory : [] ,$project->transport_brand_id,
                                                         ['class' => 'form-control', 'id'=> 'selectMarkaId', 'style'=> 'width: 100%',
                                                       'placeholder' => 'Не важно'])}}
                                                    </div>


                                                    <div class="col m2 s12">
                                                        <label for="projectOrderServiceId">Вид услуг</label>

                                                        {{Form::select('order_service_id',$projectServices, $project->order_service_id, ['id' => 'groupOrderServiceId',
                                                       'class' => 'browser-default',  'placeholder' => 'Выберите услугу'])}}

                                                    </div>

                                                    <div class="col m2 s12">
                                                        <label for="projectOrderStatusId">Статус реестра</label>

                                                        {{Form::select('status_id',[
                                                        'current' => 'текущие реестры',
                                                        'finished' => 'завершенные реестры',
                                                        'preliminary' => 'предварительные реестры',
                                                        'replacement' => 'замены',
                                                        'closed' => 'закрытый реестр',
                                                        'breakdowns' => 'срывы',
                                                        'weekend' => 'выходной'
                                                    ], '', ['class' => 'browser-default form-control', 'id' => 'projectOrderStatusId',
                                                    'placeholder' => 'Статус'])}}


                                                    </div>



                                                </div>

                                                <div class="col m12 s12">

                                                    <div class="col m2 s12">
                                                        <a href="/projects/{{$project->id}}" class="waves-effect waves-light red lighten-3 btn js-projectOrderFilterResetBtn">сбросить</a>
                                                    </div>
                                                    <div class="col m4 s12">
                                                        <button type="submit" class="waves-effect waves-light btn js-projectOrderFilterApplyBtn">применить</button>
                                                    </div>

                                                </div>



                                            </div>
                                        </div>

                                    </div>
                                </form>
                            </div>

                            <div class="row">

                                <div class="">

                                    <form action="/projects/{{$project->id}}/print-registries?{{request()->getQueryString()}}"
                                          method="POST">
                                        {{csrf_field()}}
                                        <button type="submit"><i class="fa fa-print"></i> Печать реестра</button>
                                    </form>


                                </div>

                                <div class="form-group">
                                    {{$registries->appends(request()->all())->links()}}
                                </div>

                                <div class="col s12">


                                    <div class="box-body table-responsive no-padding">
                                        <table class="table table-hover">
                                            <tbody><tr>
                                                <th>Заказ №</th>
                                                <th>Дата начала</th>
                                                <th>Дата завершения</th>
                                                <th>Кол-во</th>
                                                <th>Заказчик</th>
                                                <th>Авто/Водитель</th>
                                                <th>Адрес</th>
                                                <th>Менеджер</th>
                                                <th>Действия</th>
                                            </tr>

                                            @foreach($registries as $registry)
                                                @if($registry->order)
                                                <tr>
                                                    <td>№ {{$registry->order_id}}   <p> создано: {{$registry->created_at}}</p></td>
                                                    <td>{{$registry->start_time}} <p>{{$registry->start_point_text}} - {{$registry->end_point_text}}</p>
                                                    </td>
                                                    <td>{{$registry->end_time}}
                                                    @if($registry->value && $registry->status_id != \App\Models\Registry::STATUS_COMPLETE
                                                    && $registry->order->transport)
                                                        <p>
                                                            <form action="/projects/{{$project->id}}/registries/{{$registry->id}}/complete" method="POST" class="form-complete">
                                                                {{csrf_field()}}
                                                                <a data-target="#confirm_registry" data-toggle="modal"  class="btn btn-xs btn-sm btn-small btn-primary">закрыть</a>
                                                            </form>
                                                        </p>
                                                    @endif
                                                    </td>
                                                    <td>{{$registry->value}}</td>
                                                    <td>
                                                        <p>{{$registry->order->contractor ? $registry->order->contractor->company_name_full : null}}</p>
                                                        <p>{{$registry->order->orderService ? $registry->order->orderService->name : null}}</p>
                                                    </td>
                                                    <td>

                                                        @if($registry->order->transport)
                                                            @if($registry->order->transport->driver)
                                                                <p>{{$registry->order->transport->driver->fullName}}</p>
                                                                <p  class="label label-success"> <i class="fa fa-phone"></i> {{$registry->order->transport->driver->phone}}</p>
                                                            @endif
                                                            <p> {{$registry->order->transport->transportBrand ? $registry->order->transport->transportBrand->name : null}} {{ $registry->order->transport->car_gos_number}}</p>
                                                            <small>{{$registry->order->transport->transportCategory ? $registry->order->transport->transportCategory->name : null}}</small>

                                                        @else
                                                            <p><label class="label label-danger">! нет водителя</label></p>
                                                            <p> <label class="label label-danger">! нет авто</label></p>
                                                            <p>@if($registry->order->transportRequests->count() > 0)
                                                                    <a href="/projects/{{$project->id}}/orders/{{$registry->order->id}}/driver-requests"><span class="label label-success">{{$registry->order->transportRequests->count()}}</span>  запросов</a>
                                                                @else{{$registry->order->transportRequests->count()}} запросов@endif
                                                            </p>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <p>{{$registry->order->start_point_text}} <i class="fa fa-arrow-right" aria-hidden="true"></i> {{$registry->order->end_point_text}}</p>
                                                    </td>
                                                    <td> <p> {{$registry->order->user ? $registry->order->user->fullName : null}}</p></td>
                                                    <td class="col-md-1">
                                                        @if($registry->status_id != 5)
                                                        <a href="/projects/{{$project->id}}/registries/create?order_id={{$registry->order_id}}" class="btn btn-xs">+ реестр</a>
                                                        <a href="/projects/{{$project->id}}/registries/{{$registry->id}}/edit" ><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                                            @if(auth()->user()->hasRole('admin'))
                                                                {{ Form::open(array('url' => '/projects/'.$project->id.'/registries/'.$registry->id, 'class' => 'form-delete', 'style' => 'display:inline;')) }}
                                                                {{ Form::hidden('_method', 'DELETE') }}
                                                                <button data-toggle="modal" data-target="#confirm" class="btn btn-xs btn-danger delete" type="button"><i class="fa fa-times" aria-hidden="true"></i></button>
                                                                {{ Form::close() }}
                                                            @endif

                                                        @elseif($registry->user_id == auth()->user()->id)
                                                            <a href="/projects/{{$project->id}}/registries/create?order_id={{$registry->order_id}}" class="btn btn-xs">+ реестр</a>
                                                            <a href="/projects/{{$project->id}}/registries/{{$registry->id}}/edit" ><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                                            @if(auth()->user()->hasRole('admin'))
                                                                {{ Form::open(array('url' => '/projects/'.$project->id.'/registries/'.$registry->id, 'class' => 'form-delete', 'style' => 'display:inline;')) }}
                                                                {{ Form::hidden('_method', 'DELETE') }}
                                                                <button data-toggle="modal" data-target="#confirm" class="btn btn-xs btn-danger delete" type="button"><i class="fa fa-times" aria-hidden="true"></i></button>
                                                                {{ Form::close() }}
                                                            @endif
                                                        @endif
                                                    </td>

                                                </tr>
                                                @endif
                                            @endforeach

                                            </tbody>
                                        </table>
                                    </div>



                                </div>
                                <div class="col s12">
                                    Количество заказов: {{$registries->total()}}
                                </div>

                                {{$registries->appends(request()->all())->links()}}
                            </div>
                        </div>



                        @if(auth()->user()->hasRole('admin'))
                            <div id="services" class="tab-pane">

                                @if($project->isOwner)
                                    <div class="row">
                                        <a href="#services-form" class="" data-toggle="collapse">добавить услугу</a>
                                        <div id="services-form" class="collapse">
                                            <div class="row">
                                                <div class="input-field col m3 s12">
                                                    <input id="project-service-input" type="text" class="validate" placeholder="" value="">
                                                    <label for="project-service-input">Название услуги</label>
                                                </div>
                                                <div class="input-field col m3 s12">
                                                    <a href="#" id="project-service-add-btn" class="btn btn-xs">Добавить</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="row">
                                    <ul class="collection">
                                        @foreach($project->services as $service)
                                            <li class="collection-item">
                                                @if($project->isOwner)
                                                    <a href="#" class="js-project-service-delete"><i class="fa fa-trash"></i> </a> -
                                                @endif
                                                {{$service->name}}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>

                            </div>
                        @endif

                    </div>
                </div>

            </div>

        </section>
    </div>
    @include('modals.base_modal')
    @include('modals.confirm_registry')
@endsection


@section('css')
    <link rel="stylesheet" href="/datetimepicker/bootstrap-datetimepicker.min.css">
@endsection

@section('js-append')
    <script src="/datetimepicker/moment.js"></script>
    <script src="/datetimepicker/moment-ru.js"></script>
    <script src="/datetimepicker/bootstrap-datetimepicker.min.js"></script>
    <script>
        $(document).ready(function() {


            $('form.form-delete').on('click', function(e){
                var form=$(this);

                $(document).on('click','#delete-btn', function(){
                    form.submit();
                });
            });


            $('form.form-complete').on('click', function(e){
                var form=$(this);

                $(document).on('click','#delete-btn', function(){
                    form.submit();
                });
            });

            $("#date_start_picker").datetimepicker({
                locale: 'ru',
                widgetPositioning: {
                    horizontal: 'left',
                    vertical: 'bottom'
                }
            });

            $("#date_end_picker").datetimepicker({
                locale: 'ru',
                widgetPositioning: {
                    horizontal: 'left',
                    vertical: 'bottom'
                }
            });

            $("#groupOrderServiceId").select2({
                placeholder: "Выберите услугу",
                allowClear: true
            });

            $("#groupOrderCityId").select2({
                placeholder: "Выберите город",
                allowClear: true
            });

            $("#notificationDrivers").select2({
                placeholder: "Выберите поставщиков",
                allowClear: true,
                tags: true
            });

            function displayFieldErrors(response) {

                var gotErrors = false;
                $.each(response.responseJSON, function (key, item) {
                    $gotErrors = true;

                    $.each(item, function(key, value){
                        $.notify(value);
                    });
                });

                return gotErrors;
            }


            $(document).on('change', '#selectMarkaId', function(e){
                e.preventDefault();

                var selectModel = this.parentElement.parentElement.children[2].querySelector('#selectModelId');
                var transport_brand_id = $(this).val(),
                        csrf_token = $('input[name="_token"]').val();
                var selectNotificationDrivers = document.getElementById('notificationDrivers');

                $.ajax({
                    type: "GET",
                    url: '/ajax/list-auto-models',
                    data: {transport_brand_id: transport_brand_id, _token: csrf_token,
                        category_id: this.dataset.category_id},
                    success: function(data) {
                        selectModel.options.length = 0;
                        selectModel.options.add(new Option('Не выбрано', ''));
                        for (var i in data) {
                            selectModel.options.add(new Option(data[i],i));
                        }
                    },
                    error: function(jqXHR,code, exception) {
                        displayFieldErrors(jqXHR);
                    }
                });

                $.ajax({
                    type: "GET",
                    url: '/ajax/list-drivers',
                    data: {
                        transport_brand_id: transport_brand_id,
                        _token: csrf_token,
                        transport_category_id: this.dataset.category_id
                    },
                    success: function(data) {
                        selectNotificationDrivers.options.add(new Option('Не выбрано', ''));
                        for (var i in data) {
                            selectNotificationDrivers.options.add(new Option(data[i].auto,data[i].transport_id));
                        }
                    },
                    error: function(jqXHR,code, exception) {
                        displayFieldErrors(jqXHR);
                    }
                });

            });

            $(document).on('change', '#selectCatId', function(e){
                e.preventDefault();

                var category_id = $(this).val(),
                        csrf_token = $('input[name="_token"]').val();

                var selectBrand = this.parentElement.parentElement.children[1].querySelector('#selectMarkaId');
                var selectModel = this.parentElement.parentElement.children[2].querySelector('#selectModelId');

                $.ajax({
                    type: "GET",
                    url: '/ajax/list-auto-brands',
                    data: {category_id: category_id, _token: csrf_token},
                    success: function(data) {

                        selectBrand.options.length = 0;
                        selectBrand.options.add(new Option('Не выбрано', ''));

                        for (var i in data) {
                            selectBrand.options.add(new Option(data[i],i));
                        }

                        selectBrand.selectedIndex = 0;
                        selectBrand.setAttribute('data-category_id', category_id);

                        selectModel.options.length = 0;
                        selectModel.options.add(new Option('Не выбрано', ''));
                        selectModel.selectedIndex = 0;
                    },
                    error: function(jqXHR,code, exception) {
                        displayFieldErrors(jqXHR);
                    }
                });


            });
        });


    </script>
@endsection
