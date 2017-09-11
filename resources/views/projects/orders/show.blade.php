@extends('layouts.app')

@section('content')
    <div class="row">

        <section class="content-header">
            <h1>
                Мои проекты - <a href="/projects/{{$project->id}}">{{$project->name}}</a>
                <small>управление проектами</small>
            </h1>
        </section>

        <section class="content">
            <div class="row">
                <div class="col s12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Данные заказа</h3>
                        </div>

                        <div class="col s12">
                            <div class="col s12">
                                <div class="col s6">
                                    <ul class="collection">
                                        <li class="collection-item"> <h5>Заказ №{{$order->id}} - {{$order->orderService->name}}</h5> </li>
                                        <li class="collection-item"><i class="fa fa-user"></i> Заказчик : {{$order->contractor ? $order->contractor->company_name_full : null}} </li>

                                        <li class="collection-item"><i class="fa fa-list"></i> Основание : {{$order->contractorFileType ? $order->contractorFileType->name :null}}</li>
                                        <li class="collection-item"><i class="fa fa-calendar"></i> Срок: с {{$order->date_start}} г до {{$order->date_end}} г</li>
                                        <li class="collection-item"><i class="fa fa-car"></i>
                                                @if($order->transport)
                                                    {{$order->transport->transportCategory ? $order->transport->transportCategory->name : null}} {{$order->transport->transportBrand ? $order->transport->transportBrand->name : null}} {{ $order->transport->car_gos_number}}
                                                @endif
                                        </li>
                                        <li class="collection-item"><i class="fa fa-user"></i>
                                            Водитель :
                                            @if($order->transport && $order->transport->driver)
                                                {{$order->transport->driver->fullName}} <span  class="label label-success"> <i class="fa fa-phone"></i> {{$order->transport->driver->phone}}</span>
                                            @endif
                                        </li>
                                        <li class="collection-item"><i class="fa fa-list"></i> Ед. измерения : {{$order->priceOption->name}} </li>
                                        <li class="collection-item"><i class="fa fa-list"></i> Цена Заказчика : {{$order->client_price}} тнг/ед </li>
                                        <li class="collection-item"><i class="fa fa-list"></i> Цена Поставщика : {{$order->driver_price}} тнг/ед </li>
                                        <li class="collection-item"><i class="fa fa-list"></i> Адрес : {{$order->start_point_text}} - {{$order->end_point_text}},  {{$order->city->name_ru}}</li>
                                        <li class="collection-item"><i class="fa fa-list"></i> Телефоны Заказчика :

                                            @foreach($order->contractorPhones as $contractorPhone)
                                                {{$contractorPhone->phone}}
                                            @endforeach

                                        </li>
                                        <li class="collection-item"><i class="fa fa-comment"></i> {{$order->description}}  </li>
                                    </ul>
                                    <div class="form-group">
                                        <a href="/projects/{{$order->project_id}}/orders/{{$order->id}}/edit" class="btn btn-primary edit-btn">Изменить данные</a>
                                    </div>
                                    <div class="form-group">
                                        <form action="/projects/{{$order->project_id}}/orders/{{$order->id}}/cancel" id="cancel-order-form">
                                            <a data-order_id="{{$order->id}}" class="btn btn-primary" data-toggle="modal" data-target="#confirm">Отменить заказ</a>
                                        </form>
                                    </div>
                                </div>
                                <div class="col s6">
                                    <h5>Реестр</h5>

                                    <table style="background: white;" class="table table-bordered table-striped table-sm">
                                        <thead>
                                        <tr>
                                            <th>Дата</th>
                                            <th>Услуга</th>
                                            <th>Ед. изм.</th>
                                            <th>Количество</th>
                                        </tr>
                                        </thead>

                                        <tbody>

                                        @foreach($order->registries as $registry)

                                            <tr>
                                                <td>{{$registry->start_time}} г</td>
                                                <td>{{$order->orderService->name}}</td>
                                                <td>{{$registry->priceOption ?  $registry->priceOption->name : null}}</td>
                                                <td>{{$registry->value ? $registry->value : 0}}</td>
                                            </tr>
                                        @endforeach

                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <br>
            <br>
        </section>

    </div>

    @include('modals.base_modal')
@endsection
@section('js-append')

    <script>
        $(document).ready(function() {
            $('#confirm').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var order_id = button.data('order_id');
                var modal = $(this);
                modal.find('.modal-title').text('Отмена заказа №' + order_id)
                modal.find('.modal-body p').text('Вы действительно хотите отменить заказ №' + order_id +' ?')
                modal.find('.modal-footer #delete-btn').text('Отменить')
            });

            $('#delete-btn').on('click', function(e){
                $("#cancel-order-form").submit();
            });

        });
    </script>
@endsection