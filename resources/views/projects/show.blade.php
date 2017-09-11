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

                        <div id="registries" class="tab-pane active">
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
                                                        <label for="projectOrderStatusId">Статусы заказов</label>

                                                        {{Form::select('status_id',[
                                                        'current' => 'текущие заказы',
                                                        'finished' => 'завершенные заказы',
                                                        'cancelled' => 'отмененные заказы',
                                                        'blocked' => 'закрытые заказы',
                                                        'future' => 'предварительные заказы',
                                                        'created' => 'оформленные заказы'
                                                    ], '', ['class' => 'browser-default form-control', 'id' => 'projectOrderStatusId',
                                                    'placeholder' => 'Статус'])}}

                                                    </div>

                                                    <div class="col m2 s12">
                                                        <label for="projectOrderErrorList">Ошибки</label>


                                                        {{Form::select('error',[
                                                        null => 'Не выбрано',
                                                       'not_driver' => 'нет водителя',
                                                       'not_auto' => 'нет авто',
                                                       'late_booking' => 'позд. оформ. заказы',
                                                       'not_work_values' => 'нет объема'
                                                   ], '', ['class' => 'browser-default form-control', 'id' => 'projectOrderErrorList',
                                                   'placeholder' => 'Ошибки'])}}

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
                                    <form action="/projects/{{$project->id}}/print-orders?{{request()->getQueryString()}}"
                                          method="POST">
                                        {{csrf_field()}}

                                        <button type="submit"><i class="fa fa-print"></i> Печать заказа</button>
                                    </form>

                                </div>

                                <div class="form-group">
                                    {{$orders->appends(request()->all())->links()}}
                                </div>

                                <div class="col s12">


                                    <div class="box-body table-responsive no-padding">
                                        <table class="table table-bordered  table-hover">
                                            <tbody><tr>
                                                <th>Заказ №</th>
                                                <th>Дата начала</th>
                                                <th>Дата завершения</th>
                                                <th>Статус</th>
                                                <th>Прайсы</th>
                                                <th>Кол-во</th>
                                                <th>Авто/Водитель</th>
                                                <th>Услуга</th>
                                                <th>Менеджер</th>
                                                <th>Действия</th>
                                            </tr>

                                            @foreach($orders as $order)
                                                <tr>

                                                    <td >№ {{$order->id}}
                                                        @if(strtotime($order->created_at) > strtotime($order->date_start))
                                                            <p>
                                                            <label for="" class="label label-danger">
                                                                создано: {{$order->created_at}}
                                                            </label>
                                                            </p>
                                                        @else
                                                                <p> создано: {{$order->created_at}}</p>
                                                        @endif

                                                    </td>
                                                    <td>{{$order->date_start}} <p>{{$order->start_point_text}} - {{$order->end_point_text}}</p>
                                                    </td>
                                                    <td>{{$order->date_end}}</td>
                                                    <td>{{$order->status ? $order->status->status_text : null}}</td>
                                                    <td>
                                                        <p>Заказчик: {{$order->client_price}} тнг/ед</p>
                                                        <p>{{$order->contractor ? $order->contractor->company_name_full : null}}</p>
                                                        <p>Поставщик: {{$order->driver_price}} тнг/ед</p>
                                                        <p>Итого: {{$order->client_price - $order->driver_price}}</p>
                                                    </td>
                                                    <td>{{$order->amount}} {{$order->priceOption ? $order->priceOption->name :null}}</td>
                                                    <td>

                                                        @if($order->transport)
                                                            @if($order->transport->driver)
                                                                <p>{{$order->transport->driver->fullName}}</p>
                                                                <p  class="label label-success"> <i class="fa fa-phone"></i> {{$order->transport->driver->phone}}</p>
                                                            @endif
                                                            <p> {{$order->transport->transportBrand ? $order->transport->transportBrand->name : null}} {{ $order->transport->car_gos_number}}</p>
                                                            <small>{{$order->transport->transportCategory ? $order->transport->transportCategory->name : null}}</small>

                                                        @else
                                                            <p><label class="label label-danger">! нет водителя</label></p>
                                                            <p> <label class="label label-danger">! нет авто</label></p>
                                                            <p>@if($order->transportRequests->count() > 0)
                                                                    <a href="/projects/{{$project->id}}/orders/{{$order->id}}/driver-requests"><span class="label label-success">{{$order->transportRequests->count()}}</span>  запросов</a>
                                                                @else{{$order->transportRequests->count()}} запросов@endif
                                                            </p>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <p> {{$order->orderService ? $order->orderService->name : null}}</p>
                                                    </td>
                                                    <td>
                                                        <p> {{$order->user ? $order->user->fullName : null}}</p>
                                                    </td>
                                                    <td class="col-md-1">
                                                        <a href="/projects/{{$project->id}}/orders/create?order_id={{$order->id}}"><i class="fa fa-copy" aria-hidden="true"></i></a>
                                                        <a href="/projects/{{$project->id}}/orders/{{$order->id}}" class="group-order-edit1" data-orderid="2396"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                                        <a href="/projects/{{$project->id}}/orders/{{$order->id}}/print" target="_blank"><i class="fa fa-print" aria-hidden="true"></i></a>

                                                        <a data-toggle="modal" data-target="#comment_modal"
                                                           data-order_id="{{$order->id}}" data-project_id="{{$project->id}}"
                                                           class="projects-add-comment-form">
                                                            <i class="fa fa-comment"></i></a>


                                                        @if(auth()->user()->hasRole('admin'))
                                                            {{ Form::open(array('url' => '/projects/'.$project->id.'/orders/'.$order->id, 'class' => 'form-delete', 'style' => 'display:inline;')) }}
                                                            {{ Form::hidden('_method', 'DELETE') }}
                                                            <button data-toggle="modal" data-target="#confirm" class="btn btn-xs btn-danger delete" type="button"><i class="fa fa-times" aria-hidden="true"></i></button>
                                                            {{ Form::close() }}
                                                        @endif

                                                    </td>

                                                </tr>
                                            @endforeach

                                            </tbody>
                                        </table>
                                    </div>



                                </div>
                                <div class="col s12">
                                    Количество заказов: {{$orders->total()}}
                                </div>

                                {{$orders->appends(request()->all())->links()}}
                            </div>
                        </div>





                        <div id="totallwork" class="tab-pane">
                            <div class="row">

                                <h5> Акт выполненных работ по проекту: {{$project->name}}</h5>
                                <div class="col m12">

                                    <div class="row">
                                        <div class="col m2 s12">
                                            <label for="projectActStartDate">От</label>
                                            <input type="text" name="" class="" id="projectActStartDate" />
                                        </div>
                                        <div class="col m2 s12">
                                            <label for="projectActEndDate">До</label>
                                            <input type="text" name="" class="" id="projectActEndDate" />
                                        </div>
                                        <div class="col m4 s12">
                                            <label for="projectActServiceId">Услуга</label>
                                            <select id="projectActServiceId" name="" class="form-control myselect2" style="width:100%;">
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col m8 s12">
                                            <label for="projectActClientContragentId">Заказчик</label>
                                            <select id="projectActClientContragentId" name="" class="form-control myselect2 js-projectActClientContragentId" style="width:100%;">
                                            </select>
                                        </div>



                                        <div class="col m4 s12 hidden">
                                            <label for="projectActDocumentId">Договор</label>
                                            <select id="projectActDocumentId" name="" class="form-control myselect2" style="width:100%;">
                                                <option value="">не важно</option>
                                            </select>
                                        </div>

                                        <div class="col m4 s12 hidden">
                                            <label for="projectActDriverId">Водитель</label>
                                            <select id="projectActDriverId" name="" class="form-control myselect2" style="width:100%;">
                                                <option value="">не важно</option>
                                            </select>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col m4 s12">
                                            <a href="#" class="btn btn-xs btn-primary js-projectActGenerateBtn" id="projectActGenerateBtn">Сформировать</a>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col m2 pull pull-right">
                                            <a href="/projects/print/{{$project->id}}/act" class="" ><i class="fa fa-print"></i> Печать акт вып. работ</a>
                                        </div>
                                        <div class="col m12 s12">


                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div id="vedomost" class="tab-pane">

                            <div class="row">
                                <h5> Ведомость начислений</h5>

                                <div class="col m12">

                                    <div class="row">
                                        <div class="col m1 s12">
                                            <label for="projectVedomostStartDate">От</label>
                                            <input type="text" name="" class="" id="projectVedomostStartDate" />
                                        </div>
                                        <div class="col m1 s12">
                                            <label for="projectVedomostEndDate">До</label>
                                            <input type="text" name="" class="" id="projectVedomostEndDate" />
                                        </div>

                                        <div class="col m3 s12">
                                            <label for="projectVedomostClientContragentId">Заказчик</label>
                                            <select id="projectVedomostClientContragentId" name="" class="form-control myselect2" style="width:100%;">
                                                <option value="">не важно</option>
                                            </select>
                                        </div>

                                        <div class="col m2 s12">
                                            <label for="projectVedomostDriverId">Водитель</label>
                                            <select id="projectVedomostDriverId" name="" class="form-control myselect2" style="width:100%;">
                                                <option value="">не важно</option>
                                            </select>
                                        </div>

                                        <div class="col m3 s12">
                                            <label for="projectVedomostCreatedBy">Менеджер</label>
                                            <select id="projectVedomostCreatedBy" name="" class="form-control myselect2" style="width:100%;">
                                                <option value="">не важно</option>
                                            </select>
                                        </div>

                                        <div class="col m12 s12">

                                            <div class="col m3 s12">
                                                <label for="projectVedomostCarCatId">Вид авто</label>
                                                <select id="projectVedomostCarCatId" name="" class="form-control myselect2" style="width:100%;">
                                                    <option value="">не важно</option>
                                                </select>
                                            </div>

                                            <div class="col m3 s12">
                                                <label for="projectVedomostCarMarkaId">Марка авто</label>
                                                <select id="projectVedomostCarMarkaId" name="" class="form-control myselect2" style="width:100%;">
                                                    <option value="">не важно</option>
                                                </select>
                                            </div>

                                            <div class="col m2 s12">
                                                <label for="projectVedomostOrderServiceId">Виды услуг</label>
                                                <select class="browser-default form-control js-project-service-filter-registry-select" id="projectVedomostOrderServiceId">
                                                    <option value="">Все услуги</option>
                                                    <option value="-1">--пустые услуги--</option>
                                                </select>
                                            </div>

                                            <div class="col m2 s12">
                                                <label for="projectVedomostStatusId">Статус реестра</label>
                                                <select class="browser-default form-control" id="projectVedomostStatusId">
                                                    <option value="empty">не важно</option>
                                                    <option value="current">текущие реестры</option>
                                                    <option value="finished">завершенные реестры</option>
                                                    <option value="future">предварительные реестры</option>
                                                    <option value="rzamena">замены</option>
                                                    <option value="blocked">закрытый реестр</option>
                                                    <option value="rabort">срывы</option>
                                                    <option value="rholiday">выходной</option>
                                                </select>
                                            </div>

                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col m4 s12">
                                            <a href="#" class="btn btn-xs btn-primary js-projectVedomostGenerateBtn" id="projectVedomostGenerateBtn">Сформировать</a>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col m2 pull pull-right">
                                            <a href="/projects/{{$project->id}}/printVedomost" class="" ><i class="fa fa-print"></i> Печать ведомость</a>
                                        </div>
                                        <div class="col m12 s12">
                                        </div>
                                    </div>


                                </div>

                            </div>
                        </div>

                        <div id="contragents" class="tab-pane">
                            <div class="row">
                                <div class="col s12">
                                    <a  id="contragentCreateBtn" style="cursor: pointer;" ><i class="fa fa-plus"></i> новый контрагент</a>
                                </div>

                                <div class="col s12">

                                </div>
                            </div>
                        </div>
                        @if(auth()->user()->hasRole('admin'))
                            <div id="accounts" class="tab-pane">

                            </div>
                        @endif
                    </div>
                </div>

            </div>

        </section>

    </div>


    @include('modals.base_modal')
    @include('modals.comment_modal')
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


            $('#comment_modal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var order_id = button.data('order_id');
                var project_id = button.data('project_id');
                var modal = $(this);
                modal.find('.modal-title').text('Комментарии на заказ №' + order_id);
                modal.find('#comment-form').attr('action','/projects/'+ project_id +'/orders/'+order_id+'/comment');
            });


            $('form.form-delete').on('click', function(e){
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


            $(document).on('click','.groupOrderContactAddBtn', function(e){
                e.preventDefault();
                var clone = $('#groupOrderContactContainer').clone();
                clone.find(".groupOrderContactDeleteBtn").removeClass('hidden');
                clone.find(".groupOrderContactAddBtn").addClass('hidden');

                clone.appendTo('#contacts-cloned');
            });

            $(document).on('click', '.groupOrderContactDeleteBtn', function() {
                this.parentElement.parentElement.remove();
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

