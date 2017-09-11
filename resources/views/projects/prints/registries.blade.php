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


    {{--<link rel="stylesheet" href="/dist/css/skins/_all-skins.min.css">--}}

    @yield('css')
    @yield('js')

</head>

<body>



<style media="screen">
    #table-container{
        width: 70%;
        margin-left: 15%;
        border: solid 2px;
    }
    #report-table th, #report-table td {
        border : solid 1px !important;
    }
    td, th {
        padding: 0;
        padding-left: 3px;
        padding-right: 3px;
        border: solid 1px;
    }
</style>
<style type="text/css" media="print">
    @page
    {
        size:  auto;   /* auto is the initial value */
        margin: 0mm;  /* this affects the margin in the printer settings */
    }

    html
    {
        background-color: #FFFFFF;
        margin: 0px;  /* this affects the margin on the html before sending to printer */
    }

    body
    {
        border: none ;
        margin: 5mm 5mm 5mm 5mm; /* margin you want for the content */
    }
    #report-table th, #report-table td {
        border : solid 1px !important;
    }
    #table-container:{
        width:100%;
    }
    td, th {
        padding: 0;
        padding-left: 3px;
        padding-right: 3px;
        border: solid 1px;
    }

</style>

<a href="#" class="btn btn-primary" onclick="printDiv('printArea')" id="printPage"><i class="fa fa-print"></i> Печать</a>

<div id="printArea">
    <table  id="table-container">
        <tr>
            <td>
                <b style="margin-left:30%;">«Реестр выполненных работ по проекту  {{$project->name}}»</b>
                <div style="text-decoration: underline;text-transform: uppercase;border-style: dotted;display: block;padding: 5px;">
                    @if(array_key_exists('date_start', $params) and  array_key_exists('date_end', $params))
                        <b>Период.</b> с {{$params['date_start']}} по {{$params['date_end']}}
                    @endif
                    @if(array_key_exists('status', $params))

                        , <b>статус:</b> {{$params['status']}}
                    @endif
                    @if(array_key_exists('contractor', $params))
                        <br><b>Заказчик:</b> {{$params['contractor']->company_full_name}}
                    @endif
                    @if(array_key_exists('service', $params))
                        <br><b>Услуга:</b> {{$params['service']->name}}
                    @endif
                    @if(array_key_exists('transport_category', $params))
                        <b>Вид авто:</b> {{$params['transport_category']->name}}
                    @endif

                    @if(array_key_exists('transport_brand', $params))
                        , <b>марка авто:</b> {{$params['transport_brand']->name}}
                    @endif
                    @if(array_key_exists('manager', $params))
                        <br><b>Менеджер:</b> {{$params['manager']->fullName}}
                    @endif
                    @if(array_key_exists('driver', $params))
                        <b>Водитель:</b> {{$params['driver']->fullName}}
                    @endif
                    @if(array_key_exists('order_id', $params))
                        <b>№ заказа:</b> {{$params['order_id']}}
                    @endif
                </div>
            </td>

        </tr>
        <tr>
            <td>Всего: {{$models->count()}} реестров</td>
        </tr>


        <tr>
            <td>
                <table style="border:solid 1px;" id="report-table" rules="all">
                    <tr>
                        <th style="width:130px;border:solid 1px;">Заявка №</th>
                        <th style="width:130px;border:solid 1px;">Дата</th>
                        <th style="width:250px;border:solid 1px;">Заказчик</th>
                        <th style="width:180px;border:solid 1px;">Авто/Водитель</th>
                        <th style="width:80px;border:solid 1px;">Адрес</th>
                        <th style="width:80px;border:solid 1px;">Услуга</th>
                        <th style="width:180px;border:solid 1px;">Колич.</th>
                    </tr>

                    @foreach($models as $model)
                        @if($model->order)
                        <tr>
                            <td>{{$model->id}}

                            </td>
                            <td style="font-size:11px;">нач: {{$model->start_time}}
                                <br>зав: {{$model->end_time}}
                            </td>
                            <td style="font-size:11px;">
                                {{$model->order->contractor ? $model->order->contractor->company_name_full : null}}
                            </td>
                            <td>
                                @if($model->order->transport)
                                    {{$model->order->transport->driver ? $model->order->transport->driver->fullName : null}}
                                    <br>
                                    {{$model->order->transport->transportBrand ? $model->order->transport->transportBrand->name : null}}  {{$model->order->transport->car_gos_number}}
                                    <br>
                                    <small>{{$model->order->transport->transportCategory ? $model->order->transport->transportCategory->name : null}}</small>
                                @endif
                            </td>
                            <td>  {{$model->order->start_point_text}} - {{$model->order->end_point_text}}</td>
                            <td> {{$model->order->orderService->name}}</td>
                            <td>
                                {{$model->order->amount}} {{$model->order->priceOption->name}}
                            </td>


                        </tr>
                        @endif
                    @endforeach
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table>
                    <tr>

                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>Всего: {{$models->count()}} реестров</td>
        </tr>
        <tr>
            <td>
                <table>
                    <tr>
                        <td>

                        </td>
                        <td >

                            <div style="float:right;margin-right:2%;">
                                <b>Исполнитель: {{auth()->user()->fullName}}</b> <br> Дата: {{\Carbon\Carbon::now()}}
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>

<script type="text/javascript">
        function printDiv(divName) {
            console.log(document.getElementById(divName));
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }
</script>
</body>
</html>